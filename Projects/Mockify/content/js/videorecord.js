let preview = document.getElementById('preview');
let timerDisplay = document.getElementById('timer');
let nextBtn = document.getElementById('nextBtn');
let questionInput = document.getElementById('questionInput');
let hiddenQuestionInput = document.getElementById('hiddenQuestionInput');
let questionText = document.getElementById('questionText');

let mediaRecorder;
let recordedChunks = [];
let countdown;
let timeLeft = 10;

function updateTimer() {
  let min = Math.floor(timeLeft / 60).toString().padStart(2, '0');
  let sec = (timeLeft % 60).toString().padStart(2, '0');
  timerDisplay.textContent = `${min}:${sec}`;
  if (timeLeft <= 0) {
    clearInterval(countdown);
    stopRecordingAndEnableNext();
  } else {
    timeLeft--;
  }
}

function startTimer() {
  updateTimer();
  countdown = setInterval(updateTimer, 1000);
}

function stopRecordingAndEnableNext() {
  if (mediaRecorder && mediaRecorder.state === "recording") {
    mediaRecorder.stop();
  }
  nextBtn.disabled = false;
}

let videoWidth = 640;
let videoHeight = 480;
let canvas = document.createElement('canvas');
let ctx = canvas.getContext('2d');
canvas.width = videoWidth;
canvas.height = videoHeight;

let animationFrameId;

// ✅ Word-wrap utility
function wrapText(context, text, x, y, maxWidth, lineHeight) {
  const words = text.split(' ');
  let line = '';
  for (let n = 0; n < words.length; n++) {
    const testLine = line + words[n] + ' ';
    const metrics = context.measureText(testLine);
    const testWidth = metrics.width;

    if (testWidth > maxWidth && n > 0) {
      context.fillText(line.trim(), x, y);
      line = words[n] + ' ';
      y += lineHeight;
    } else {
      line = testLine;
    }
  }
  context.fillText(line.trim(), x, y);
}

async function initCameraAndRecord() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: { width: videoWidth, height: videoHeight },
      audio: true
    });
    preview.srcObject = stream;

    function drawFrame() {
      ctx.drawImage(preview, 0, 0, videoWidth, videoHeight);

      const subtitleHeight = 80; // increased to allow more lines
      ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
      ctx.fillRect(0, videoHeight - subtitleHeight, videoWidth, subtitleHeight);

      ctx.font = '24px sans-serif';
      ctx.fillStyle = 'white';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'top';

      const text = questionText.textContent || '';
      const maxWidth = videoWidth - 40;
      const lineHeight = 30;
      const x = videoWidth / 2;
      const y = videoHeight - subtitleHeight + 2;

      wrapText(ctx, text, x, y, maxWidth, lineHeight);

      animationFrameId = requestAnimationFrame(drawFrame);
    }
    drawFrame();

    let canvasStream = canvas.captureStream(30);
    let combinedStream = new MediaStream();
    canvasStream.getVideoTracks().forEach(t => combinedStream.addTrack(t));
    stream.getAudioTracks().forEach(t => combinedStream.addTrack(t));

    startRecording(combinedStream);

  } catch (err) {
    alert("Error accessing camera/mic: " + err.message);
  }
}

function startRecording(stream) {
  recordedChunks = [];
  mediaRecorder = new MediaRecorder(stream);

  mediaRecorder.ondataavailable = function(e) {
    if (e.data.size > 0) {
      recordedChunks.push(e.data);
    }
  };

  mediaRecorder.onstop = function() {
    cancelAnimationFrame(animationFrameId);
    const blob = new Blob(recordedChunks, { type: "video/webm" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    a.download = '<?php echo $_SESSION["user_name"]; ?>_q<?php echo $currentIndex; ?>_' + Date.now() + '.webm';
    document.body.appendChild(a);
    a.click();
    setTimeout(() => {
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    }, 100);
  };

  mediaRecorder.start();
  startTimer();
}

// Show modal on page load if not done
<?php if (!$done): ?>
window.onload = function () {
  const modal = new bootstrap.Modal(document.getElementById('questionModal'), {
    backdrop: 'static',
    keyboard: false
  });
  modal.show();

  document.getElementById('startBtn').addEventListener('click', function () {
    const question = questionInput.value.trim();
    if (question === '') {
      alert('Please enter a question.');
      return;
    }
    questionText.textContent = question;
    hiddenQuestionInput.value = question;
    modal.hide();
    initCameraAndRecord();
  });
};
<?php endif; ?>