async function fetchProjectStats(csvUrl) {
    if (!csvUrl || csvUrl === "LINK_HERE") return { avg: 0, count: 0 };
    try {
        const res = await fetch(csvUrl);
        const csvData = await res.text();
        const rows = csvData.split('\n').slice(1);
        const ratings = rows.map(row => {
            const cols = row.split(',');
            const rawRating = cols[2];
            if (rawRating && rawRating.trim().length > 0) {
                const starCount = (rawRating.match(/⭐/g) || []).length;
                if (starCount > 0) return starCount;
                const firstChar = parseFloat(rawRating.trim().charAt(0));
                return isNaN(firstChar) ? null : firstChar;
            }
            return null;
        }).filter(n => n !== null && !isNaN(n));

        if (ratings.length === 0) return { avg: 0, count: 0 };
        return {
            count: ratings.length,
            avg: (ratings.reduce((a, b) => a + b, 0) / ratings.length).toFixed(1)
        };
    } catch (e) {
        return { avg: 0, count: 0 };
    }
}

async function loadProjectsContent() {
    try {
        const response = await fetch('content/section-projects.txt');
        const data = await response.json();

        // Featured Projects rendering
        const featuredPromises = data.featured.map(async (project, index) => {
            const config = project.ratingConfig;
            const stats = config ? await fetchProjectStats(config.csvUrl) : { avg: 0, count: 0 };
            const hasRating = config && config.csvUrl !== "LINK_HERE";
            const pId = `feat-${index}`;

            return `
                <div class="group glass p-8 rounded-3xl hover:border-blue-500/50 transition-all duration-500 flex flex-col h-full shadow-2xl relative overflow-hidden text-white">
                    <div class="mb-6 text-blue-500"><i class="${project.icon} text-4xl"></i></div>
                    <h3 class="text-2xl font-black mb-3 group-hover:text-blue-400 tracking-tighter uppercase italic">${project.title}</h3>
                    
                    ${hasRating && stats.count > 0 ? `
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex text-yellow-500 text-[10px]">
                                ${Array.from({length: 5}, (_, i) => `<i class="${i < Math.floor(stats.avg) ? 'fas' : 'far'} fa-star"></i>`).join('')}
                            </div>
                            <span class="text-slate-400 font-bold text-xs">${stats.avg}</span>
                            <span class="text-slate-600 text-[10px]">(${stats.count})</span>
                        </div>
                    ` : ''}

                    <p class="text-slate-400 text-sm leading-relaxed mb-8">${project.description}</p>
                    
                    <div class="mt-auto space-y-6">
                        <div class="flex flex-wrap gap-2">
                            ${project.tags.map(tag => `<span class="text-[10px] px-3 py-1 bg-blue-500/10 text-blue-400 rounded-full font-bold uppercase tracking-widest">${tag}</span>`).join('')}
                        </div>
                        <div id="btn-container-${pId}" class="grid ${hasRating ? 'grid-cols-2' : 'grid-cols-1'} gap-3">
                            ${hasRating ? `<button onclick="submitRating('${project.title}', '${config.formBaseUrl}', '${config.entryRating}', '${config.entryRemark}', 'btn-container-${pId}')" class="inline-flex items-center justify-center py-4 px-4 border border-slate-700 hover:border-yellow-500/50 text-slate-300 hover:text-yellow-500 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all focus:outline-none"><i class="fas fa-star mr-2 text-[8px]"></i> Rate</button>` : ''}
                            <a href="${project.url}" target="_blank" class="inline-flex items-center justify-center py-4 px-4 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all group/btn">View <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i></a>
                        </div>
                    </div>
                </div>`;
        });

        // Other Projects rendering
        const othersPromises = data.others.map(async (project, index) => {
            const config = project.ratingConfig;
            const stats = config ? await fetchProjectStats(config.csvUrl) : { avg: 0, count: 0 };
            const hasRating = config && config.csvUrl !== "LINK_HERE";
            const pId = `other-${index}`;

            return `
                <div class="group glass p-6 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-blue-500/30 transition-all text-white">
                    <div class="flex items-center gap-6">
                        <i class="${project.icon} text-2xl text-blue-500/50 group-hover:text-blue-500 transition-colors"></i>
                        <div>
                            <h4 class="font-bold tracking-tight group-hover:text-blue-400 transition-colors uppercase italic">${project.title}</h4>
                            <p class="text-slate-400 text-sm">${project.description}</p>
                            ${hasRating && stats.count > 0 ? `<p class="text-[10px] text-yellow-500 mt-1">⭐ ${stats.avg} (${stats.count} reviews)</p>` : ''}
                        </div>
                    </div>
                    <div id="btn-container-${pId}" class="flex gap-2">
                        ${hasRating ? `<button onclick="submitRating('${project.title}', '${config.formBaseUrl}', '${config.entryRating}', '${config.entryRemark}', 'btn-container-${pId}')" class="px-4 py-2 border border-slate-700 text-slate-300 text-[10px] font-bold uppercase rounded-lg hover:text-yellow-500">Rate</button>` : ''}
                        <a href="${project.url}" target="_blank" class="px-6 py-2 border border-slate-700 hover:border-blue-500 text-slate-300 hover:text-white text-xs font-bold uppercase tracking-widest rounded-lg transition-all text-center">View Project</a>
                    </div>
                </div>`;
        });

        const [featHtml, otherHtml] = await Promise.all([Promise.all(featuredPromises), Promise.all(othersPromises)]);
        document.getElementById('featured-projects-container').innerHTML = featHtml.join('');
        document.getElementById('other-projects-container').innerHTML = otherHtml.join('');

    } catch (error) {
        console.error('Error:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadProjectsContent);

function submitRating(title, baseUrl, rId, remId, containerId) {
    const actionContainer = document.getElementById(containerId);
    const ratingLabels = { "5": "⭐⭐⭐⭐⭐ Excellent", "4": "⭐⭐⭐⭐ Very Good", "3": "⭐⭐⭐ Good", "2": "⭐⭐ Fair", "1": "⭐ Needs Improvement" };
    const googleFormUrl = `${baseUrl}?usp=pp_url&entry.${rId}=${encodeURIComponent(ratingLabels["5"])}&entry.${remId}=How%20was%20it%3F`;
    window.open(googleFormUrl, '_blank');
    if (actionContainer) {
        const original = actionContainer.innerHTML;
        actionContainer.innerHTML = `<p class="text-[10px] font-bold text-green-400 uppercase italic animate-pulse">Rating Opened!</p>`;
        setTimeout(() => actionContainer.innerHTML = original, 5000);
    }
}