<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ronald Fernandez Mendoza</title>
	<link href="styles/styles.css" rel="stylesheet" />

</head>
<body class="main-content">
    
<!-- first page - homepage -->
<header class="container header active" id="home">
    <div class="header-content">
        <div class="left-header">
            <div class="h-shape"></div>
            <div class="image"><img alt="" src="img/profile.webp" style="border-radius: 25px !important;" /></div>
        </div>

        <div class="right-header">
            <h1 class="name"><span>Ronald Fernandez Mendoza</span></h1>
            <p>Programmer &amp; Web Developer</p>
            <p><small>I love programming in different languages and always look for ways to improve my skills and learn new things.</small></p>

            <div class="contact-icons">
                <div class="contact-icon">
                    <h2>
<a href="https://facebook.com/446046595495367" target="_blank" aria-label="Facebook">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFFFFF" viewBox="0 0 24 24">
    <path d="M22 12a10 10 0 1 0-11.625 9.875v-6.987h-2.34V12h2.34V9.797c0-2.311 1.377-3.59 3.487-3.59.999 0 2.043.178 2.043.178v2.25h-1.151c-1.134 0-1.487.706-1.487 1.43V12h2.53l-.404 2.888h-2.126v6.987A10.002 10.002 0 0 0 22 12z"/>
  </svg>
</a> &nbsp;&nbsp;

<a href="https://linkedin.com/in/imronaldmendoza" target="_blank" aria-label="LinkedIn">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFFFFF" viewBox="0 0 24 24">
    <path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zm.02 4.75H2V21h3V8.25zm7.5 0h-2.98V21h3V14.25c0-1.8 2.5-1.94 2.5 0V21h3v-7.5c0-4.33-5-4.16-5 0V8.25z"/>
  </svg>
</a> &nbsp;&nbsp;

<a href="https://github.com/nomuu" target="_blank" aria-label="GitHub">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFFFFF" viewBox="0 0 24 24">
    <path d="M12 .5A11.5 11.5 0 0 0 .5 12c0 5.08 3.29 9.39 7.86 10.92.58.11.79-.25.79-.55v-1.9c-3.2.69-3.87-1.54-3.87-1.54-.53-1.35-1.3-1.71-1.3-1.71-1.06-.73.08-.72.08-.72 1.17.08 1.79 1.2 1.79 1.2 1.04 1.78 2.73 1.26 3.4.97.11-.75.41-1.26.74-1.55-2.56-.29-5.26-1.28-5.26-5.69 0-1.26.45-2.29 1.19-3.1-.12-.29-.52-1.46.11-3.04 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.64 1.58.24 2.75.12 3.04.74.81 1.18 1.84 1.18 3.1 0 4.42-2.71 5.39-5.29 5.67.42.36.79 1.1.79 2.22v3.29c0 .31.21.67.8.55A11.5 11.5 0 0 0 23.5 12 11.5 11.5 0 0 0 12 .5z"/>
  </svg>
</a> &nbsp;&nbsp;

<a href="https://www.youtube.com/channel/UC1girC1ZoP3lN61ivKGsKCA" target="_blank" aria-label="YouTube">
  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFFFFF" viewBox="0 0 24 24">
    <path d="M23.5 6.2s-.2-1.65-.83-2.38a3.1 3.1 0 0 0-2.2-.84C17.23 2.5 12 2.5 12 2.5h-.01s-5.22 0-8.47.48a3.1 3.1 0 0 0-2.2.84C.7 4.55.5 6.2.5 6.2S.25 8.06.25 9.91v1.85c0 1.85.25 3.7.25 3.7s.2 1.65.83 2.38a3.13 3.13 0 0 0 2.2.84c3.25.48 8.47.48 8.47.48s5.23 0 8.48-.48a3.1 3.1 0 0 0 2.2-.84c.63-.73.83-2.38.83-2.38s.25-1.85.25-3.7V9.9c0-1.85-.25-3.7-.25-3.7zM9.75 14.57V8.92l5.54 2.82-5.54 2.83z"/>
  </svg>
</a>

                    </h2>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- end of first page-->

<main>
    <?php
    // second page - about me
    include 'About.html';
    // third page - portfolio
    include 'Portfolio.html';
    // fourth page - courses and seminars
    include 'Blogs.html';
    // fifth page - contact
    include 'Contact.html';
    ?>
</main>

<div class="controls">
<div class="control active-btn" data-id="home" data-bs-toggle="tooltip" title="Home page">
  <!-- Home Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 576 512">
    <path d="M280.4 148.3L96 300.1V464c0 8.8 7.2 16 16 16l112-.3c8.8 0 16-7.2 16-16V368c0-8.8 
    7.2-16 16-16h64c8.8 0 16 7.2 16 16v95.7c0 8.8 7.2 16 16 16l112 .3c8.8 0 
    16-7.2 16-16V300L295.6 148.3c-6-5.1-14.8-5.1-20.8 0zM571.6 
    251.5l-61.6-53.6V48c0-8.8-7.2-16-16-16H464c-8.8 0-16 
    7.2-16 16v72.6L318.5 43.2c-23.6-20.6-58.4-20.6-82 
    0L4.3 251.5c-6.7 5.9-7.4 16.1-1.5 
    22.6l21.4 24.6c5.9 6.7 16.1 7.4 22.6 
    1.5L64 270.7V464c0 26.5 21.5 48 48 
    48h112c26.5 0 48-21.5 48-48V368h64v96c0 
    26.5 21.5 48 48 48h112c26.5 0 48-21.5 
    48-48V270.7l17.1 15c6.7 5.9 16.8 5.2 
    22.6-1.5l21.4-24.6c5.9-6.6 5.2-16.7-1.5-22.6z"/>
  </svg>
</div>

<div class="control" data-id="about" data-bs-toggle="tooltip" title="About Me">
  <!-- User Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 448 512">
    <path d="M224 256a128 128 0 1 0 0-256 128 128 0 1 0 0 
    256zm89.6 32h-11.2c-22.2 10.3-46.9 16-72.4 
    16s-50.2-5.7-72.4-16H134.4A134.4 134.4 0 0 0 
    0 422.4v25.6C0 481.6 30.4 512 67.2 
    512h313.6c36.8 0 67.2-30.4 
    67.2-67.2v-25.6c0-74.2-60.2-134.4-134.4-134.4z"/>
  </svg>
</div>

<div class="control" data-id="portfolio" data-bs-toggle="tooltip" title="My Projects">
  <!-- Briefcase Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 512 512">
    <path d="M464 128h-80V80c0-26.5-21.5-48-48-48H176c-26.5 
    0-48 21.5-48 48v48H48C21.5 128 0 149.5 0 
    176v256c0 26.5 21.5 48 48 48h416c26.5 
    0 48-21.5 48-48V176c0-26.5-21.5-48-48-48zM176 
    80h160v48H176V80zm320 352c0 8.8-7.2 16-16 
    16H48c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 
    16-16h416c8.8 0 16 7.2 16 16v256z"/>
  </svg>
</div>

<div class="control" data-id="blogs" data-bs-toggle="tooltip" title="Seminars and courses">
  <!-- Newspaper Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 576 512">
    <path d="M552 64H88c-13.2 0-24 10.8-24 
    24v304H24c-13.2 0-24 10.8-24 
    24s10.8 24 24 24h528c13.2 0 24-10.8 
    24-24V88c0-13.2-10.8-24-24-24zm-88 
    64h64v272H464V128zm-96 
    0h64v64h-64zm0 
    96h64v64h-64zm0 
    96h64v64h-64zm-96-192h64v64h-64zm0 
    96h64v64h-64zm0 
    96h64v64h-64zm-96-192h64v256h-64z"/>
  </svg>
</div>

<div class="control" data-id="contact" data-bs-toggle="tooltip" title="Message me">
  <!-- Envelope Open Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 512 512">
    <path d="M64 128h384v32l-192 96L64 
    160v-32zm0 64l192 96 192-96v192H64V192zM0 
    96c0-17.7 14.3-32 32-32h448c17.7 
    0 32 14.3 32 32v320c0 35.3-28.7 
    64-64 64H64c-35.3 0-64-28.7-64-64V96z"/>
  </svg>
</div>

</div>
<script src="app.js"></script>
<script>
document.addEventListener('contextmenu', function (e) {
  e.preventDefault();
});

    document.addEventListener('DOMContentLoaded', function () {
          e.preventDefault();
  alert("Right-click is disabled on this website.");
  
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>
</html>