async function loadAboutContent() {
    try {
        const response = await fetch('content/section-about.txt');
        if (!response.ok) throw new Error("About config not found");
        
        const data = await response.json();

        // 1. Load Main Details (gamit ang innerHTML para gumana yung span tags)
        document.getElementById('about-main').innerHTML = data.mainDetails;

        // 2. Load Additional Details
        document.getElementById('about-additional').innerHTML = data.additionalDetails;

        // 3. Load Beyond the Code List
        const listHtml = data.beyondTheCode.map(item => `
            <li class="flex flex-col group/item">
                <span class="flex items-center text-blue-500 mb-1">
                    <i class="${item.icon} mr-2"></i> 
                    <strong class="text-slate-200 uppercase tracking-tighter">${item.title}</strong>
                </span>
                <span class="text-slate-500 group-hover/item:text-slate-400 transition-colors">${item.description}</span>
            </li>
        `).join('');
        document.getElementById('about-list').innerHTML = listHtml;

    } catch (error) {
        console.error('Error loading about content:', error);
    }
}

// Siguraduhin na matawag ito sa DOMContentLoaded
document.addEventListener('DOMContentLoaded', loadAboutContent);