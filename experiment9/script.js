let operation = "";

function appender(numoper) {
    operation += numoper;
    display();
}

function display() {
    document.getElementById('result').innerHTML = operation;
}

function resclear() {
    operation = "";
    document.getElementById('result').innerHTML = "";
}

async function calculate() {
    if (!operation) return;
    
    // Check for valid current operation visually before sending.
    const resultElement = document.getElementById('result');
    resultElement.innerHTML = "..."; 
    
    try {
        let formData = new FormData();
        formData.append('expression', operation);
        formData.append('action', 'calculate');

        let response = await fetch('api.php', {
            method: 'POST',
            body: formData
        });
        
        let data = await response.json();
        
        if (data.status === 'success') {
            resultElement.innerHTML = data.result;
            operation = data.result.toString();
            updateHistory(data.history);
        } else {
            resultElement.innerHTML = "Error";
            operation = "";
        }
    } catch (e) {
        resultElement.innerHTML = "Error";
        operation = "";
    }
}

async function clearHistory() {
    let formData = new FormData();
    formData.append('action', 'clear_history');

    await fetch('api.php', {
        method: 'POST',
        body: formData
    });
    
    document.getElementById('history-list').innerHTML = "";
}

function updateHistory(historyString) {
    let newEntryHTML = `<div class='history-item'>${historyString}</div>`;
    let historyList = document.getElementById('history-list');
    // Prepend to top of the history list
    historyList.innerHTML = newEntryHTML + historyList.innerHTML;
}
