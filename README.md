# Restaurant Website

A simple PHP restaurant website that allows users to view and order food items, reserve tables, and manage carts. This project uses **Composer** for dependencies, **Docker** for containerization, and can be deployed on **AWS** for hosting.

---

## Features

1. **Menu & Product Management**  
   - Displays food items from the database on the homepage (`index.php`).  
   - Users can view details of each product (`product.php`) and add them to the cart.

2. **Cart & Checkout**  
   - Session-based cart (`cart.php`) where users can add or remove items.  
   - Checkout flow (`checkout.php`) supporting Stripe payments or Cash on Delivery.

3. **User Authentication**  
   - **Sign Up** (`signup.php`) for new users.  
   - **Login** (`login.php`) for returning users.  
   - **Profile** (`profile.php`) to view or update user details and see order history.

4. **Table Reservation**  
   - A form (`reservation.php`) where guests can book a table by entering name, date, and time.  
   - Admin can manage reservations in the admin panel.

5. **Admin Panel**  
   - **Login** (`admin/login.php`) with admin credentials.  
   - **Dashboard** (`admin/dashboard.php`) to upload and manage food items (name, price, image, etc.).  
   - **Orders Management** (`admin/orders.php`) to accept, cancel, or delete orders.  
   - **Reservations Management** (`admin/reservations.php`) to accept, cancel, or delete table reservations.
   - **Customers** (`admin/customers.php`) to view customer list, their orders, and reservations.

6. **Database**  
   - Uses **MySQL** (version 5.7 recommended) for storing users, products, orders, and reservations.
   - **phpMyAdmin** included for easy database management (defined in `docker-compose.yml`).

---

## Technologies Used

- **PHP 7.2**  
  - Main server-side language for rendering pages and handling form submissions.
- **Composer**  
  - Dependency manager for installing required PHP libraries (e.g., Stripe, Dotenv, etc.).
- **Docker & Docker Compose**  
  - Containerize the application for consistent development and deployment.
  - `docker-compose.yml` spins up three containers:
    1. **web** (PHP/Apache)
    2. **db** (MySQL)
    3. **phpmyadmin** (for DB management)
- **AWS EC2**  
  - Host the Dockerized application under AWS Free Tier.

---

## Getting Started (Local)

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/<YourUsername>/<YourRepo>.git
   cd <YourRepo>
   ```

2. **Create/Update `.env` File** (if using environment variables):
   ```env
   STRIPE_SECRET_KEY=sk_test_...
   DB_HOST=db
   DB_USER=root
   DB_PASS=example
   ```

3. **Run with Docker Compose**:
   ```bash
   docker-compose build
   docker-compose up -d
   ```
   - **web** container → accessible at `http://localhost:8080` (if you mapped `"8080:80"`)
   - **phpmyadmin** → `http://localhost:8081`
   - MySQL is on `port 3306`.

4. **Import Database**:
   - Access **phpMyAdmin** at `http://localhost:8081`
   - Log in with `root` / `example`
   - Import your `.sql` file into `restaurant_db`.

5. **Test**:
   - Visit `http://localhost:8080` to see the homepage.
   - Sign up, log in, add products to cart, etc.

---

## Deploying on AWS

1. **Launch an EC2 Instance** (t2.micro or t3.micro, Amazon Linux 2).  
2. **Install Docker & Docker Compose**.  
3. **Clone this Repo** on the EC2 instance:
   ```bash
   git clone https://github.com/<YourUsername>/<YourRepo>.git
   cd <YourRepo>
   ```
4. **docker-compose up -d** to run containers in the background.  
5. **Open** required ports (e.g., 8080, 8081, 3306) in the EC2 Security Group.  
6. **Import Database** either via phpMyAdmin (`http://<EC2-Public-IP>:8081`) or CLI.

Visit `http://<EC2-Public-IP>:8080/` in your browser to see the site live.

---

## Directory Structure

```
restaurant-website/
├── admin/
│   ├── dashboard.php
│   ├── login.php
│   ├── orders.php
│   ├── reservations.php
│   └── ...
├── assets/
│   └── uploads/       # images for food items
├── db.php             # database connection with PDO
├── functions.php      # helper functions
├── index.php          # homepage listing food items
├── product.php        # product details
├── cart.php           # cart functionality
├── checkout.php       # checkout logic
├── reservation.php    # table reservation form
├── signup.php
├── login.php
├── Dockerfile
├── docker-compose.yml
├── composer.json
├── composer.lock
└── ...
```

---

## Contributing

1. **Fork** the repo and create a new branch for your feature.  
2. **Commit** your changes with descriptive messages.  
3. **Push** to your branch and open a **Pull Request**.

---

## License

This project is open-source. You’re free to use, modify, and distribute it under the terms of the [MIT License](LICENSE).

---

## Contact

- **Author**: [Sadman Sakib](https://www.linkedin.com/in/sadman-sakib-3b86a6117/)
- **Email**: sadmansakib123450@gmail.com

Feel free to open issues or pull requests if you have suggestions or need help.
