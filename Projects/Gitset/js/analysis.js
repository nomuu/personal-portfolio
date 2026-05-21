// SIGURADUHIN NA BUONG-BUO ITONG KEY NA 'TO
const GEMINI_API_KEY = "AIzaSyCz4R72f5MyQAVkJT-JUQWLB6eCsQkQKUc";
const GEMINI_MODEL = "gemini-2.0-flash"; // I-update lang dito pag may bagong model

async function updateAIAnalysis() {
    const verdict = document.getElementById('ai-verdict');
    const prosContainer = document.getElementById('ai-pros');
    const consContainer = document.getElementById('ai-cons');

    if (!verdict) return;

    // 1. KUNIN ANG DATA (SAFETY CHECK)
    const form = document.getElementById('gitSetForm');
    if (!form) {
        verdict.innerHTML = "<span class='text-red-600'>ERROR: Form 'gitSetForm' not found! Check your HTML ID.</span>";
        return;
    }

    const formData = new FormData(form);
    let setupDetails = "";

    formData.forEach((value, key) => {
        if(value && value.trim() !== "" && value !== "Loading...") {
            setupDetails += `${key}: ${value}, `;
        }
    });

    // KUNG WALANG LAMAN ANG FORM, STOP AGAD
    if (setupDetails.length < 10) {
        verdict.innerHTML = "<span class='text-orange-600 font-bold uppercase'>⚠️ Fill up the form first before inspecting!</span>";
        return;
    }

    // Loading UI
    verdict.innerHTML = "<div class='animate-pulse text-blue-600 font-black italic'>ENGINEER IS CALCULATING CHASSIS DYNAMICS... 🏎️💨</div>";
    if (prosContainer) prosContainer.innerHTML = "";
    if (consContainer) consContainer.innerHTML = "";

    // 2. PROMPT
    const prompt = `You are a professional RC Race Engineer. Analyze this setup: ${setupDetails}. 
    Provide a deep technical narrative analysis. No bullets. No lists. 
    Predict handling (entry, mid, exit) and balance.
    Respond ONLY in this JSON format: {"analysis": "Your paragraph here"}`;

    try {
        // FIX: gemini-1.5-flash -> gemini-2.0-flash (updated model)
        const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/${GEMINI_MODEL}:generateContent?key=${GEMINI_API_KEY}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                contents: [{ parts: [{ text: prompt }] }]
            })
        });

        const data = await response.json();
        
        if (data.error) {
            throw new Error(data.error.message);
        }

        if (!data.candidates || !data.candidates[0]) {
            throw new Error("AI returned an empty response. Try again.");
        }

        const aiText = data.candidates[0].content.parts[0].text;
        const cleanJson = aiText.replace(/```json|```/g, "").trim();
        const result = JSON.parse(cleanJson);

        // 3. DISPLAY RESULTS
        verdict.innerHTML = `
            <div class="p-4 border-l-8 border-blue-600 bg-blue-50 text-gray-900 leading-relaxed font-bold italic shadow-inner">
                "${result.analysis}"
            </div>
        `;

    } catch (error) {
        console.error("DEBUG_INFO:", error);
        verdict.innerHTML = `<div class='bg-red-100 p-4 border-2 border-red-600 text-red-700 font-black uppercase text-[10px]'>
            System_Error: ${error.message}<br>
            <span class='text-gray-500 font-mono italic mt-2 block'>Note: If "API key not found", check your paste. If "CORS", it will work once LIVE.</span>
        </div>`;
    }
}