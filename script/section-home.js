async function loadHomeContent() {
    try {
        const response = await fetch('content/section-home.txt');
        const data = await response.json();

        // Load Name
        document.getElementById('home-name').textContent = data.name;

        // Load Professions (joining with the | separator)
        const professionsHtml = data.professions.map((p, index) => {
            const separator = index < data.professions.length - 1 
                ? '<span class="text-slate-700 font-normal mx-1">|</span>' 
                : '';
            return `${p} ${separator}`;
        }).join('');
        document.getElementById('home-professions').innerHTML = professionsHtml;

        // Load Slogan
        document.getElementById('home-slogan').textContent = `"${data.slogan}"`;

        // Load Socials
        const socialsHtml = data.socials.map(s => `
            <a href="${s.url}" target="_blank" class="text-slate-500 hover:text-blue-500 transition-all transform hover:-translate-y-1">
                <i class="${s.icon}"></i>
            </a>
        `).join('');
        document.getElementById('home-socials').innerHTML = socialsHtml;

    } catch (error) {
        console.error('Error loading home content:', error);
    }
}

// Tawagin ang function pagka-load ng page
window.addEventListener('DOMContentLoaded', loadHomeContent);