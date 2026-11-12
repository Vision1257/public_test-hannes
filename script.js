const CONFIG = {
    TILE_SIZE: 20,
    GAME_SPEED: 90,
    INITIAL_SNAKE: [{ x: 5, y: 5 }, { x: 6, y: 5 }],
    INITIAL_APPLES: 5,
    COLORS: {
        background: "#f0f0f0ff",
        grid: "#36802d",
        snakeHead: "#1019a0ff",
        snakeBody: "#7aa8e4ff",
        apple: "#e03131",
        appleShine: "#ff8787"
    }
};

const canvas = document.querySelector("canvas");
const ctx = canvas.getContext("2d");
const overlay = document.getElementById("overlay");
const overlayTitle = document.getElementById("overlay-title");
const startBtn = document.getElementById("start-btn");

const GRID_WIDTH = Math.floor(canvas.width / CONFIG.TILE_SIZE);
const GRID_HEIGHT = Math.floor(canvas.height / CONFIG.TILE_SIZE);

let snake = [];
let dirX = 0;
let dirY = 0;
let apples = [];
let score = 0;
let isGameRunning = false;
let lastTime = 0;
let animationFrameId;

function setDirection(x, y) {
    if (x === -dirX && y === -dirY && snake.length > 1) return;
    dirX = x;
    dirY = y;
}

function createSingleApple(currentApples = []) {
    let newApple;
    do {
        newApple = {
            x: Math.floor(Math.random() * GRID_WIDTH),
            y: Math.floor(Math.random() * GRID_HEIGHT)
        };
    } while (
        snake.some(segment => segment.x === newApple.x && segment.y === newApple.y) ||
        currentApples.some(apple => apple.x === newApple.x && apple.y === newApple.y)
    );

    return newApple;
}

function initApples() {
    apples = [];
    for (let i = 0; i < CONFIG.INITIAL_APPLES; i++) {
        apples.push(createSingleApple(apples));
    }
}

function drawBackground() {
    ctx.fillStyle = CONFIG.COLORS.background;
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.strokeStyle = CONFIG.COLORS.grid;
    ctx.lineWidth = 0.5;

    for (let x = 0; x <= canvas.width; x += CONFIG.TILE_SIZE) {
        ctx.beginPath();
        ctx.moveTo(x, 0);
        ctx.lineTo(x, canvas.height);
        ctx.stroke();
    }
    for (let y = 0; y <= canvas.height; y += CONFIG.TILE_SIZE) {
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(canvas.width, y);
        ctx.stroke();
    }
}

function drawSnake() {
    const size = CONFIG.TILE_SIZE;
    const padding = 1;
    snake.forEach((segment, i) => {
        const ratio = i / snake.length;
        ctx.fillStyle = i === 0 ? CONFIG.COLORS.snakeHead : CONFIG.COLORS.snakeBody;
        ctx.globalAlpha = 1 - (ratio * 0.4);

        const x = segment.x * size + padding;
        const y = segment.y * size + padding;
        const s = size - padding * 2;

        ctx.beginPath();
        ctx.roundRect(x, y, s, s, 4);
        ctx.fill();
    });
    ctx.globalAlpha = 1;
}

function drawApples() {
    const size = CONFIG.TILE_SIZE;

    apples.forEach(apple => {
        const centerX = apple.x * size + size / 2;
        const centerY = apple.y * size + size / 2;
        const radius = (size / 2) - 3;

        // // 1. Schatten unter dem Apfel
        // ctx.fillStyle = "rgba(0, 0, 0, 0.15)";
        // ctx.beginPath();
        // ctx.arc(centerX + 1, centerY + 3, radius, 0, Math.PI * 2);
        // ctx.fill();

        // 2. Apfel-Grundkörper mit Farbverlauf
        const gradient = ctx.createRadialGradient(
            centerX - radius / 3, centerY - radius / 3, 2,
            centerX, centerY, radius
        );
        gradient.addColorStop(0, "#ff6b6b");
        gradient.addColorStop(1, CONFIG.COLORS.apple || "#cc1111");

        ctx.fillStyle = gradient;
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, 0, Math.PI * 2);
        ctx.fill();

        // // 3. Stiel des Apfels
        // ctx.strokeStyle = "#5a3d28";
        // ctx.lineWidth = 2;
        // ctx.lineCap = "round";
        // ctx.beginPath();
        // ctx.moveTo(centerX, centerY - radius + 2);
        // ctx.quadraticCurveTo(centerX + 2, centerY - radius - 4, centerX + 4, centerY - radius - 5);
        // ctx.stroke();

        // // 4. Kleines grünes Blatt
        // ctx.fillStyle = "#2ecc71";
        // ctx.beginPath();
        // ctx.ellipse(centerX + 6, centerY - radius - 3, 4, 2, Math.PI / 4, 0, Math.PI * 2);
        // ctx.fill();

        // // 5. Glanzpunkt
        // ctx.fillStyle = CONFIG.COLORS.appleShine || "rgba(255, 255, 255, 0.5)";
        // ctx.beginPath();
        // ctx.arc(centerX - 4, centerY - 4, radius / 3.5, 0, Math.PI * 2);
        // ctx.fill();
    });
}

function checkCollision(head) {
    if (head.x < 0 || head.x >= GRID_WIDTH || head.y < 0 || head.y >= GRID_HEIGHT) {
        return true;
    }

    if (snake.some(segment => segment.x === head.x && segment.y === head.y)) {
        return true;
    }
    return false;
}

function gameOver() {
    isGameRunning = false;
    cancelAnimationFrame(animationFrameId);

    overlayTitle.innerText = `Game Over! (Punkte: ${score})`;
    startBtn.innerText = "Nochmal spielen";
    overlay.classList.remove("hidden");
}

function move() {
    if (dirX === 0 && dirY === 0) return;

    const newHead = {
        x: snake[0].x + dirX,
        y: snake[0].y + dirY
    };

    if (checkCollision(newHead)) {
        gameOver();
        return;
    }

    snake.unshift(newHead);

    const eatenAppleIndex = apples.findIndex(apple => apple.x === newHead.x && apple.y === newHead.y);

    if (eatenAppleIndex !== -1) {
        score += 10;
        apples.splice(eatenAppleIndex, 1);
        apples.push(createSingleApple(apples));
    } else {
        snake.pop();
    }
}

function drawScore() {
    ctx.save();

    const text = `Score: ${score}`;
    ctx.font = "bold 16px sans-serif";
    
    
    const textWidth = ctx.measureText(text).width;
    const padding = 10;
    const x = 15;
    const y = 15;
    const width = textWidth + padding * 2;
    const height = 30;

   
    ctx.fillStyle = "rgba(0, 0, 0, 0.6)"; 
    ctx.beginPath();
    ctx.roundRect(x, y, width, height, 8); 
    ctx.fill();

   
    ctx.fillStyle = "#FFFFFF"; 
    ctx.textAlign = "left";
    ctx.textBaseline = "middle";
    ctx.fillText(text, x + padding, y + height / 2);

    ctx.restore();
}

function gameLoop(currentTime) {
    if (!isGameRunning) return;

    animationFrameId = requestAnimationFrame(gameLoop);

    const elapsed = currentTime - lastTime;
    if (elapsed < CONFIG.GAME_SPEED) return;

    lastTime = currentTime - (elapsed % CONFIG.GAME_SPEED);

    move();

    drawBackground();
    drawApples();
    drawSnake();
    drawScore();
}

function startGame() {
    snake = [...CONFIG.INITIAL_SNAKE];
    dirX = 0;
    dirY = 0;
    score = 0;
    initApples();
    isGameRunning = true;

    overlay.classList.add("hidden");

    drawBackground();
    drawApples();
    drawSnake();
    drawScore();

    lastTime = performance.now();
    animationFrameId = requestAnimationFrame(gameLoop);
}

window.addEventListener("keydown", (e) => {
    if (["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight", " "].includes(e.key)) {
        e.preventDefault();
    }

    if (!isGameRunning) return;

    switch (e.key) {
        case "ArrowRight": setDirection(1, 0); break;
        case "ArrowLeft": setDirection(-1, 0); break;
        case "ArrowUp": setDirection(0, -1); break;
        case "ArrowDown": setDirection(0, 1); break;
    }
});

startBtn.addEventListener("click", startGame);