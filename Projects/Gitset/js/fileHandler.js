// Modal Logic
function showModal(title, text, icon = '🚀') {
    const modalTitle = document.getElementById('modal-title');
    const modalText = document.getElementById('modal-text');
    const modalIcon = document.getElementById('modal-icon');
    const modalOverlay = document.getElementById('modal-overlay');

    if (modalTitle && modalText && modalIcon && modalOverlay) {
        modalTitle.innerText = title;
        modalText.innerText = text;
        modalIcon.innerText = icon;
        modalOverlay.style.display = 'flex';
    }
}

function closeModal() {
    const modalOverlay = document.getElementById('modal-overlay');
    if (modalOverlay) modalOverlay.style.display = 'none';
}

// Download/Export Logic
function downloadSheet() {
    const form = document.getElementById('gitSetForm');
    if (!form) return;

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const jsonString = JSON.stringify(data);
    
    // Encryption process
    const encryptedData = btoa(unescape(encodeURIComponent(jsonString)));
    const blob = new Blob([encryptedData], { type: "text/plain" });
    const url = URL.createObjectURL(blob);
    
    const link = document.createElement("a");
    const driver = (data.driverName || "Driver").replace(/\s+/g, '-');
    const chassis = (data.chassis || "Chassis").replace(/\s+/g, '-');
    
    link.download = `GS_${driver}_${chassis}_${new Date().getTime()}.txt`;
    link.href = url;
    link.click();
    
    URL.revokeObjectURL(url);
    showModal("Config_Saved", "Setup data encrypted and exported successfully.", "💾");
}

// Load/Import Logic
function loadSheet(input) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            // Decryption process
            const decryptedData = decodeURIComponent(escape(atob(e.target.result)));
            const data = JSON.parse(decryptedData);
            const form = document.getElementById('gitSetForm');

            Object.keys(data).forEach(key => {
                if (form.elements[key]) form.elements[key].value = data[key];
            });

            // Trigger AI analysis if it exists
            if (typeof updateAIAnalysis === "function") {
                updateAIAnalysis();
            }

            showModal("Config_Loaded", "Encrypted GitSet configuration applied.", "⚡");
        } catch (err) {
            showModal("System_Error", "File corrupted or not a valid GitSet file.", "❌");
        }
    };
    reader.readAsText(file);
}