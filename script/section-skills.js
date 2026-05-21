async function loadSkillsContent() {
    try {
        const response = await fetch('content/section-skills.txt');
        if (!response.ok) throw new Error("Skills config not found");
        
        const data = await response.json();

        // 1. Load Technical Stack
        const techStackHtml = data.techStack.map(item => `
            <div class="glass p-6 rounded-2xl border-white/5 hover:border-blue-500/50 transition-all">
                <p class="text-blue-400 font-black mb-1 uppercase">${item.category}</p>
                <p class="text-xs text-slate-500 font-mono">${item.skills}</p>
            </div>
        `).join('');
        document.getElementById('tech-stack-container').innerHTML = techStackHtml;

        // 2. Load Core Strengths (with progress bars)
        const strengthsHtml = data.coreStrengths.map(item => `
            <div class="space-y-2">
                <div class="flex justify-between text-xs font-bold uppercase tracking-widest">
                    <span>${item.name}</span><span class="text-blue-500">${item.percentage}%</span>
                </div>
                <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-600 rounded-full transition-all duration-1000" style="width: ${item.percentage}%"></div>
                </div>
            </div>
        `).join('');
        document.getElementById('core-strengths-container').innerHTML = strengthsHtml;

        // 3. Load Professional Development
        const profDevHtml = data.professionalDevelopment.map(item => `
            <li class="flex items-start">
                <i class="fas fa-chevron-right text-blue-500 mr-3 mt-1.5 text-xs"></i>
                ${item}
            </li>
        `).join('');
        document.getElementById('prof-dev-list').innerHTML = profDevHtml;

    } catch (error) {
        console.error('Error loading skills content:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadSkillsContent);