# FoodShare - Community Food Sharing Platform

FoodShare is a full-stack web application designed to connect individuals, restaurants, and grocers with surplus food to charities and people in need. It serves as a "Living Archive of Freshness," ensuring that excess edible goods are redistributed efficiently instead of going to waste.

### 🌟 1. What is this website?
FoodShare is a localized platform that bridges the gap between food donors and receivers. With a modern, highly polished "editorial" interface, it treats food donation with the dignity and premium experience it deserves. 

### ⚙️ 2. What it does?
- **User Roles:** The platform supports two distinct user roles: **Donors** and **Receivers**, each with personalized dashboards.
- **Post Surplus Food:** Donors can easily upload photos and details (quantity, expiry time, location, contact info) of available surplus food.
- **Live Feed Discovery:** Receivers can explore an active, localized feed of available food with real-time expiration alerts (e.g., highlighting "URGENT" foods).
- **Claiming System:** Receivers can securely claim food posts, changing the status from "available" to "claimed."
- **Impact Tracking:** The system securely manages users, food post lifecycle, and tracks claimed items.

### 💡 3. Why was it made?
To combat the pressing issue of global food waste. Every day, tons of perfectly good food are discarded. FoodShare was built to:
- Provide an elegant, intuitive tool to make sharing simple and fast.
- Empower communities to redirect surplus food to those who actually need it.
- Act as the **Final Project** demonstrating comprehensive mastery of web technologies (Front-end, Back-end, and Database management).

### 🛠️ 4. Tech Stack Used
* **Frontend:**
  * HTML5 & Semantic HTML
  * Utility-first CSS framework (Tailwind CSS concepts utilized for styling)
  * Google Material Symbols (for scalable iconography)
  * Custom Google Fonts (Inter/Outfit style configurations for typography)
* **Backend:**
  * PHP (Vanilla PHP, utilized for core logic, routing, and form handling)
  * PHP Data Objects (PDO) for secure database interactions
* **Database:**
  * MySQL (Relational Data Modeling with InnoDB constraints)

### 📂 5. Project Structure
```text
Final_project/
├── auth.php                  # User Registration and Login handling
├── claim_food.php            # Logic for a receiver to claim an available food item
├── claim_success.php         # Success routing page after claiming
├── config.php                # Database credentials and secure PDO setup
├── dashboard.php             # Core routing controller for dashboards
├── donor_dashboard.php       # Dashboard for Donors (managing posts)
├── feed.php                  # The main live feed of all available food posts
├── index.php                 # The landing page and hero section
├── logout.php                # Secure session destruction
├── post_food.php             # Form and logic for creating a new food donation post
├── receiver_dashboard.php    # Dashboard for Receivers (viewing past claims)
├── schema.sql                # MySQL database architecture and table creation scripts
├── assets/                   # CSS stylesheets, Javascript, and static assets
├── includes/                 # Reusable PHP partials (header.php, footer.php)
└── uploads/                  # User-uploaded images for food posts
```

### 🧑‍💻 6. Code Explanation (How it works under the hood)

**1. Database Architecture (`schema.sql`)**
* The database relies on three core relational tables:
  * `users`: Stores user identity, authentication (`password_hash`), and `role` (`ENUM` of 'donor' or 'receiver').
  * `food_posts`: Stores the actual surplus item. Bound to `users` via `donor_id` foreign key. Includes metadata like `expiry_time` and a `status` toggle.
  * `claims`: Bridges a `receiver` to a specific `post_id`. Logs the transaction.

**2. Authentication & Sessions (`auth.php`, `config.php`)**
* `config.php` sets up the `$pdo` connection.
* Users register as either a donor or a receiver. Passwords are cryptographically hashed using PHP's native password functions. 
* Upon successful login, secure Session variable (`$_SESSION['user_id']` & `role`) are set, ensuring subsequent pages protect their routes.

**3. The Application Flow**
* **Landing (`index.php`):** Unauthenticated and authenticated users see a highly optimized hero section. A PHP script queries the `/config.php` PDO instance for the 3 most recently added food items (`WHERE status = 'available'`) and populates the teaser cards.
* **Donation Journey (`post_food.php`):** Authenticated donors submit a `POST` form (including file uploads managed explicitly by PHP to `uploads/`). The back-end validates and creates an `INSERT` statement into `food_posts`.
* **Receiver Journey (`feed.php` -> `claim_food.php`):** Receivers browse the feed. When they click to claim an item, `claim_food.php` is executed. In a secure transaction, the script:
  1. Verifies the item is still available.
  2. Creates a record in the `claims` table.
  3. Updates the `food_posts` table to switch the status from `available` to `claimed`.

**4. UI & Templating (`includes/`)**
* Because PHP serves page loads natively, `header.php` and `footer.php` act as templates. They are `require_once`'d in almost every file to keep the navigation bar, styling links, and site logic deeply consistent across the codebase while drastically reducing code duplication.
