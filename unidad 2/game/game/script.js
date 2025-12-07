document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const bruh = canvas.getContext('2d')
    const startButton = document.getElementById('startButton');
    const resetButton = document.getElementById('resetButton');

    let gameRunning = false; 
    let gameOver = false; 
    let animationFrameId; 

    let score = 0;

    const player = {
        x: canvas.width / 2,
        y: canvas.height - 30,
        radius: 10,
        color: '#007bff',
        speed: 25
    };
    const clone = {
        x: canvas.width / 2,
        y: canvas.height - 30,
        radius: 8,
        color: '#FF0000',
        speed: 20
    };

    function drawPlayer() {
        ctx.beginPath();
        ctx.arc(player.x, player.y, player.radius, 0, Math.PI * 2);
        ctx.fillStyle = player.color;
        ctx.fill();
        ctx.closePath();
    }

    function drawClone() {
        ctx.beginPath();
        ctx.arc(clone.x, clone.y, clone.radius, 0, Math.PI * 2);
        ctx.fillStyle = clone.color;
        ctx.fill();
        ctx.closePath();
    }

    class Block {
        constructor(x, y, width, height, dy, color) {
            this.x = x;
            this.y = y;
            this.width = width;
            this.height = height;
            this.dy = dy;
            this.color = color;
        }

        draw() {
            ctx.fillStyle = this.color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }

        update() {
            this.y += this.dy;

            if (this.y > canvas.height) {
                this.y = -this.height; 
                this.x = Math.random() * (canvas.width - this.width); 
                this.dy = 1.5 + Math.random() * 2;

                score += 1;
            }
        }

        collides(player) {
            const collisionX = player.x + player.radius > this.x && player.x - player.radius < this.x + this.width;
            const collisionY = player.y + player.radius > this.y && player.y - player.radius < this.y + this.height;

            return collisionX && collisionY;
        }
        collides(clone) {
            const collisionX = clone.x + clone.radius > this.x && clone.x - clone.radius < this.x + this.width;
            const collisionY = clone.y + clone.radius > this.y && clone.y - clone.radius < this.y + this.height;

            return collisionX && collisionY;
        }
    }

    const blocks = [];
    const blockCount = 10;

    function initializeBlocks() {
        blocks.length = 0;
        for (let i = 0; i < blockCount; i++) {
            const width =  Math.random() * 75 + 25;
            const height = 20;
            const x = Math.random() * (canvas.width - width);
            
            const y = -height - (i * 80); 
            const dy = 1.5 + Math.random() * 2;
            const color = `hsl(${i * 60 + 200}, 70%, 50%)`;

            blocks.push(new Block(x, y, width, height, dy, color));
        }
    }

    function gameLoop() {
        if (!gameRunning) return; 

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (const block of blocks) {
            block.update();
            block.draw();

            if (block.collides(player) || block.collides(clone)) {
                gameOver = true;
                gameRunning = false;
                cancelAnimationFrame(animationFrameId);
                startButton.disabled = true;
                alert('Ya vete del ciber, obtuviste: ' + score + ' puntos');
                return; 
            }
        }

        drawPlayer();
        drawClone();

        animationFrameId = requestAnimationFrame(gameLoop);
    }

    document.addEventListener('keydown', (e) => {
        if (!gameRunning || gameOver) return; 

        if (e.key === 'ArrowLeft') {
            player.x -= player.speed;
        } else if (e.key === 'ArrowRight') {
            player.x += player.speed;
        }
        if (e.key === 'a') {
            clone.x -= clone.speed;
        } else if (e.key === 'd') {
            clone.x += clone.speed;
        }

        player.x = Math.max(player.radius, Math.min(canvas.width - player.radius, player.x));
        clone.x = Math.max(clone.radius, Math.min(canvas.width - clone.radius, clone.x));
    });

    startButton.addEventListener('click', () => {
        if (!gameRunning && !gameOver) {
            gameRunning = true;
            startButton.disabled = true;
            gameLoop(); 
            
            ctx.clearRect(0, 0, canvas.width, canvas.height); 
        }
    });

    resetButton.addEventListener('click', () => {
        location.reload(); 
        score = 0;
    });

    function drawInitialScreen() {
        initializeBlocks();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawPlayer();
        drawClone();
        
        ctx.fillStyle = '#333';
        ctx.font = '24px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('Pulsa "Iniciar Juego" para empezar', canvas.width / 2, canvas.height / 2);
    }

    drawInitialScreen();

});
