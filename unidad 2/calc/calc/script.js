let currentExpression = '';
const display = document.getElementById('display');

function appendCharacter(char) {
    if (display.textContent === '0' && (char >= '0' && char <= '9' || char === '.')) {
        currentExpression = char;
    } else {
        currentExpression += char;
    }
    
    const lastChar = currentExpression.slice(-2, -1);
    const isOperator = (c) => ['+', '-', '*', '/'].includes(c);
    
    if (currentExpression.length > 1 && isOperator(char) && isOperator(lastChar)) {
        currentExpression = currentExpression.slice(0, -2) + char;
    }

    display.textContent = currentExpression;
}

function clearDisplay() {
    currentExpression = '';
    display.textContent = '0';
}

function calculateResult() {
    try {
        let result = eval(currentExpression); 
        
        if (result % 1 !== 0) {
            result = parseFloat(result.toFixed(8)); // Limita a 8 decimales
        }
        
        display.textContent = result;
        currentExpression = String(result);
    } catch (error) {
        display.textContent = 'Error';
        currentExpression = '';
    }
}
