<?php
session_save_path('/tmp');
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: index.php');
    exit;
}

// Initialize session variables if not already set
if (!isset($_SESSION['mock_index'])) {
    $_SESSION['mock_index'] = 0;
    $_SESSION['mock_questions'] = [];
}

$maxMocks = 3;
$done = false;

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle reset
    if (isset($_POST['reset'])) {
        $_SESSION['mock_index'] = 0;
        $_SESSION['mock_questions'] = [];
        header('Location: interview.php');
        exit;
    }

    // Handle question submission
    if (isset($_POST['question_input'])) {
        $_SESSION['mock_questions'][$_SESSION['mock_index']] = $_POST['question_input'];
        $_SESSION['mock_index']++;
    }

        // Check if done
    if ($_SESSION['mock_index'] >= $maxMocks) {
        // Reset session if needed or keep data for finish page
        header('Location: finish.php');
        exit;
    } else {
        header('Location: interview.php');
        exit;
    }

}

$currentIndex = $_SESSION['mock_index'];
$currentQuestion = $_SESSION['mock_questions'][$currentIndex] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/png">
  <title>Mockify - Interview</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #000428, #004e92);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .centered {
      text-align: center;
      padding: 60px 20px 40px;
    }
    .question {
      font-size: 1.6rem;
      font-weight: 600;
      margin-bottom: 20px;
    }
    #preview {
      border: 4px solid #00bcd4;
      border-radius: 12px;
      width: 100%;
      max-width: 520px;
      height: 360px;
      background-color: #000;
      margin-bottom: 20px;
    }
    #timer {
      font-size: 1.4rem;
      font-weight: bold;
      color: #00ffc6;
      animation: pulse 1s infinite alternate;
    }
    @keyframes pulse {
      from { opacity: 1; }
      to { opacity: 0.5; }
    }

    .btn-main:hover {
      background-color: #00bfa5;
      color: #fff;
    }
    @media (max-width: 768px) {
  .question {
    font-size: 1.2rem;
  }
  #preview {
    height: auto;
  }
}
.btn-main {
  margin-top: 1rem;
  width: 100%;
  background: linear-gradient(to right, #0072ff, #00c6ff);
  border: none;
  padding: 12px;
  font-size: 1rem;
  font-weight: 600;
  color: #fff;
  text-transform: uppercase;
  cursor: pointer;
  transition: background 0.3s ease;
  text-align: center;
  display: inline-block;
}
.btn-main:disabled {
  background: #a0c8ff;
  cursor: not-allowed;
}
.btn-main:hover:not(:disabled) {
  background: linear-gradient(to right, #005ecb, #00a5e0);
}

  </style>
</head>
<body>

<div class="container py-5">
  <div class="row align-items-center">
      <div class="mb-4 mb-md-0 text-center" style="width: 60%; height: 80vh; padding: 0; float: left;">
  <video id="preview" autoplay muted 
         style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; border: 4px solid #00bcd4; display: block;">
  </video>
</div>
<div style="width: 40%; float: left; padding-left: 0;">

  <!-- Right column: Greeting, Question, Timer, Button - ~30% width -->
  <h2 style="margin-left: 0; padding-left: 0;">Hi <?php echo htmlspecialchars($_SESSION['user_name']); ?>,</h2>
  <h4 style="margin-left: 0; padding-left: 0;">
    This is mock interview <?php echo min($currentIndex + 1, $maxMocks); ?> of <?php echo $maxMocks; ?>.
  </h4>

  <?php if (!$done): ?>
    <p class="question mt-4" id="questionText" style="margin-left: 0; padding-left: 0;">
      <?php echo htmlspecialchars($currentQuestion ?: ''); ?>
    </p>
<div id="timer" class="mb-3" style="margin-left: 0; padding-left: 0; font-size: 5rem;">01:00</div>


    <form id="interviewForm" method="post" style="margin-left: 0; padding-left: 0;">
      <input type="hidden" name="question_input" id="hiddenQuestionInput" />
<button type="submit" class="btn-main" id="nextBtn" disabled>
  Next Question
</button>

    </form>
        <button type="button" class="btn-main" data-bs-toggle="modal" data-bs-target="#confirmCancelModal">
  Finish the Interview
</button>
  <?php endif; ?>
</div>


<div style="clear: both;"></div>
  </div>
</div>


<!-- Confirmation Modal -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Done in Interview?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p>The current interview session will be interrupted and your recording will stop.</p>
        <p>Are you sure you want to End?</p>
      </div>

      <div class="modal-footer">
        <a href="finish.php" class="btn btn-danger">Yes, Finish my Interview</a>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No, Continue Interview</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Question Input -->
<div class="modal-lg modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">📝 Prepare Your Question</h5>
      </div>

      <div class="modal-body">
        <p>
          Once you click <strong>"Start Interview"</strong>, the timer will begin immediately. Make sure your question is final before proceeding.
        </p>

        <p>
          For a better practice experience, we recommend wearing clean semi-formal or formal attire. Try to position yourself in front of a tidy background with good lighting — just like you would in a real online interview.
        </p>

        <label for="questionInput" class="form-label mt-3">Your Question</label>
<input type="text" class="form-control" id="questionInput"
       placeholder="e.g., How do you handle unexpected challenges at work?"
       maxlength="150" minlength="8" required />
       <small class="text-muted d-block mt-2">
          Type a question you'd like to practice — it could be technical, behavioral, or situational.
        </small>
      </div>

      <div class="modal-footer">
          
        <a href="index.php" class="btn btn-secondary">Cancel & Back to Home</a>
        <button type="button" class="btn btn-primary" id="startBtn">Start Interview</button>
      </div>
    </div>
  </div>
</div>

<?php include 'videorecord.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
