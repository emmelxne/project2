<?php
// Database connection parameters
$host = "127.0.0.1:3307";
$user = "faquser";
$password = "mysql";
$dbname = "bit102_ass";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="faq.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<header>
    <nav class="navbar">
        <div class="logo-section">
            <img src="logo.png" alt="Gallery Logo" class="logo">
            <h1 class="gallery-title">Demuore Art</h1>
        </div>
        <div class="hamburger" onclick="toggleMenu()">☰</div>
        <ul class="nav-links">
            <li><a href="index.html#home">Home</a></li>
            <li><a href="index.html#about">About</a></li>
            <li><a href="index.html#events">Events</a></li>
            <li><a href="index.html#venue">Venue</a></li>
            <li><a href="schedule.htm">Schedule</a></li>
            <li><a href="event-details.html" class="tickets-btn">Tickets</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li><a href="feedback html.html">Feedback</a></li>
        </ul>
    </nav>        
</header>

<main style="min-height: 50vh; padding-bottom: 100px;">
  <div class="container text-center my-5">
    <h1 class="faq-title">FAQs</h1>
    <p class="faq-subtitle">Frequently Asked Questions</p>
  </div>

  <div class="container">
        <ul class="nav nav-tabs justify-content-center mb-4" id="faqTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tickets">Tickets & Booking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#visit">Your Visit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#accessibility">Accessibility</a>
            </li>
        </ul>

        <div class="tab-content">
            <?php
            $categories = ['Tickets', 'Visit', 'Accessibility'];
            foreach ($categories as $catIndex => $category):
                $sql = "SELECT * FROM faqs WHERE category = '$category'";
                $result = $conn->query($sql);
                $tabId = strtolower(str_replace(' ', '', $category));
            ?>
            <div class="tab-pane fade <?php if($catIndex === 0) echo 'show active'; ?>" id="<?php echo $tabId; ?>">
                <div class="accordion" id="<?php echo $tabId; ?>Accordion">
                    <?php
                    if ($result->num_rows > 0):
                        $i = 0;
                        while($row = $result->fetch_assoc()):
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?php echo $tabId . 'Heading' . $i; ?>">
                            <button class="accordion-button <?php echo $i !== 0 ? 'collapsed' : ''; ?>" type="button"
                                data-bs-toggle="collapse" data-bs-target="#<?php echo $tabId . 'Collapse' . $i; ?>"
                                aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                aria-controls="<?php echo $tabId . 'Collapse' . $i; ?>">
                                <?php echo htmlspecialchars($row['question']); ?>
                            </button>
                        </h2>
                        <div id="<?php echo $tabId . 'Collapse' . $i; ?>" class="accordion-collapse collapse <?php echo $i === 0 ? 'show' : ''; ?>"
                            aria-labelledby="<?php echo $tabId . 'Heading' . $i; ?>" data-bs-parent="#<?php echo $tabId; ?>Accordion">
                            <div class="accordion-body">
                                <?php echo htmlspecialchars($row['answer']); ?>
                            </div>
                        </div>
                    </div>
                    <?php $i++; endwhile; else: ?>
                        <p class="text-muted text-center">No FAQs available for <?php echo $category; ?>.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<footer>
    <p>© 2025 Demuore Art. All rights reserved.</p>
</footer>

<script>
    let lastScrollTop = 0;
    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", function () {
        let scrollTop = window.scrollY || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            navbar.style.transform = "translateY(-100%)";
        } else {
            navbar.style.transform = "translateY(0)";
        }

        lastScrollTop = scrollTop;
    });

</script>

</body>
</html>
