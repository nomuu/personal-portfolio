async function loadContactContent() {
    try {
        const response = await fetch('content/section-contact.txt');
        if (!response.ok) throw new Error("Contact config not found");
        
        const data = await response.json();

        // Load Greeting & Description
        document.getElementById('contact-greeting').textContent = data.greeting;
        document.getElementById('contact-description').textContent = data.description;

        // Load Email
        const emailLink = document.getElementById('contact-email-link');
        emailLink.href = `mailto:${data.email}`;
        emailLink.textContent = data.email;

        // Load Location
        document.getElementById('contact-location').textContent = data.location;

        // Load Languages (Joining with <br> for the stacked look)
        document.getElementById('contact-languages').innerHTML = data.languages.join('<br>');

        // Load Socials
        const socialsHtml = data.socials.map(s => `
            <a href="${s.url}" target="_blank" class="text-slate-400 hover:text-blue-500 transition-all text-xl">
                <i class="${s.icon}"></i>
            </a>
        `).join('');
        document.getElementById('contact-socials').innerHTML = socialsHtml;

    } catch (error) {
        console.error('Error loading contact content:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadContactContent);