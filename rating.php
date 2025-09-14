<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV Charging Station Reviews</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIzLTEwL21vdGFybzdfZWxlY3RyaWNfdmVoaWNsZV9jaGFyZ2luZ19zdGF0aW9uc19pbl9tb2Rlcm5fY2l0eV85ZDhmZGNlMi00OTBlLTQ5YzYtYWE2ZC0zOGM1MjQ4YjAwNzhfMS5qcGc.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
            height: 100vh;
            overflow-y: auto;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            border-radius: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            color: #ffa500;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .review {
            border-bottom: 1px solid #555;
            padding: 20px 0;
        }

        .review:last-child {
            border-bottom: none;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .review-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .review-header .rating {
            color: #ffa500;
            font-size: 18px;
        }

        .review p {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.5;
        }

        .review small {
            font-size: 12px;
            color: #aaa;
        }

        .add-review {
            margin-top: 40px;
        }

        .add-review h3 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .add-review label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        .add-review input,
        .add-review select,
        .add-review textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .add-review button {
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .add-review button:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EV Charging Station Reviews</h1>
        </div>

        <!-- Reviews Section -->
        <div class="reviews" id="reviews"></div>

        <!-- Add Review Section -->
        <div class="add-review">
            <h3>Add Your Review</h3>
            <label for="station">Station Name with locality:</label>
            <input type="text" id="station" placeholder="Enter station name">

            <label for="rating">Rating:</label>
            <select id="rating">
                <option value="">Select Rating</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>

            <textarea id="reviewText" placeholder="Write your review here..." rows="4"></textarea>
            <button id="submitReview">Submit Review</button>
        </div>
    </div>

    <script>
        const reviewsContainer = document.getElementById('reviews');

        // Default reviews
        const defaultReviews = [
            { stationName: 'TATA', ratingValue: 5, reviewText: 'Excellent service and fast charging!', date: 'January 15, 2025' },
            { stationName: 'OLA', ratingValue: 4, reviewText: 'Good location, but a bit crowded.', date: 'January 14, 2025' },
            { stationName: 'EPSON', ratingValue: 3, reviewText: 'Average experience. Needs better maintenance.', date: 'January 13, 2025' },
        ];

        // Load reviews from localStorage
        function loadReviews() {
            const reviews = JSON.parse(localStorage.getItem('reviews')) || [];
            reviewsContainer.innerHTML = ''; // Clear previous reviews
            reviews.forEach((review) => displayReview(review));
        }

        // Display a single review
        function displayReview({ stationName, ratingValue, reviewText, date }) {
            const reviewContainer = document.createElement('div');
            reviewContainer.className = 'review';

            const reviewHeader = document.createElement('div');
            reviewHeader.className = 'review-header';

            const reviewerName = document.createElement('h3');
            reviewerName.textContent = stationName;

            const reviewerRating = document.createElement('span');
            reviewerRating.className = 'rating';
            reviewerRating.textContent = '⭐'.repeat(ratingValue);

            reviewHeader.appendChild(reviewerName);
            reviewHeader.appendChild(reviewerRating);

            const reviewParagraph = document.createElement('p');
            reviewParagraph.textContent = reviewText;

            const reviewDate = document.createElement('small');
            reviewDate.textContent = `Reviewed on ${date}`;

            reviewContainer.appendChild(reviewHeader);
            reviewContainer.appendChild(reviewParagraph);
            reviewContainer.appendChild(reviewDate);

            reviewsContainer.appendChild(reviewContainer);
        }

        // Add a new review
        document.getElementById('submitReview').addEventListener('click', function () {
            const stationName = document.getElementById('station').value.trim();
            const ratingValue = document.getElementById('rating').value;
            const reviewText = document.getElementById('reviewText').value.trim();

            if (!stationName || !ratingValue || !reviewText) {
                alert('Please fill in all fields before submitting your review.');
                return;
            }

            const currentDate = new Date().toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            });

            const review = { stationName, ratingValue, reviewText, date: currentDate };

            // Save to localStorage
            const reviews = JSON.parse(localStorage.getItem('reviews')) || [];
            reviews.push(review);
            localStorage.setItem('reviews', JSON.stringify(reviews));

            // Reload reviews to reflect changes
            loadReviews();

            // Clear the form
            document.getElementById('station').value = '';
            document.getElementById('rating').value = '';
            document.getElementById('reviewText').value = '';
        });

        // Load existing or default reviews on page load
        if (!localStorage.getItem('reviews')) {
            localStorage.setItem('reviews', JSON.stringify(defaultReviews));
        }
        loadReviews();
    </script>
</body>
</html>
