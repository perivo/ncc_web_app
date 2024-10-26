# NCC Web Application

## Overview

The NCC Web Application is a dynamic, user-centric platform designed to facilitate educational enrollment, content access, and user management. This application serves as a comprehensive hub for users to engage with learning materials, manage their profiles, and track their enrollment statuses efficiently. With a focus on responsiveness and usability, the NCC Web App enhances the overall educational experience for both learners and administrators.

### Key Features

- **User Registration and Login**: Secure authentication system enabling users to register and log in seamlessly.
- **Profile Management**: Users can easily view and edit their profiles, including personal information and profile pictures.
- **Enrollment System**: Users can enroll in various educational units and track their enrollment statuses in real-time.
- **Admin Dashboard**: Admin users have access to robust tools for managing user accounts and overseeing enrollments.
- **Content Access**: Users can access articles, galleries, and a variety of learning materials.
- **Responsive Design**: Fully mobile-friendly layout, ensuring accessibility across devices.
- **Error Handling**: Comprehensive error management for a smoother user experience.

## Tech Stack

The NCC Web Application leverages the following technologies:

- **Frontend**: 
  - HTML5
  - CSS3
  - JavaScript
  - Bootstrap 4 (for styling and responsive design)

- **Backend**:
  - PHP (for server-side scripting)
  - MySQL (for database management)

- **Server**:
  - XAMPP (for local development environment)

## Project Structure

The project is organized into the following structure:

```
project_root/
│
├── public/                   # Publicly accessible files
│   ├── index.php             # Main entry point of the application
│   ├── profile.php           # User profile page
│   ├── edit_profile.php      # Edit profile page
│   ├── enrollment.php         # Enrollment page
│   ├── articles.php          # Articles page
│   ├── gallery.php           # Gallery page
│   ├── learning.php          # Learning materials page
│   ├── contact.php           # Contact us page
│   ├── login.php             # User login page
│   └── register.php          # User registration page
│
├── includes/                 # Shared files
│   ├── header.php            # Header file for navigation bar
│   ├── footer.php            # Footer file
│   └── config.php            # Database connection and configuration
│
├── assets/                   # Static assets
│   ├── css/                  # CSS files
│   └── js/                   # JavaScript files
│
├── uploads/                  # Directory for uploaded files (e.g., profile pictures)
│
├── scripts/                  # Scripts for backend logic
│   └── logout.php            # Logout functionality
│
└── README.md                 # Project documentation
```

## Setup Instructions

To set up the NCC Web Application on your local machine, follow these steps:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/perivo/project_root.git
   ```

2. **Navigate to the Project Directory**:
   ```bash
   cd project_root
   ```

3. **Start XAMPP**:
   - Launch the XAMPP Control Panel.
   - Start the Apache and MySQL modules.

4. **Create a Database**:
   - Open phpMyAdmin (accessible at `http://localhost/phpmyadmin`).
   - Create a new database named `ncc_db`.

5. **Import the Database Schema**:
   - Import the SQL file containing the database schema (e.g., `ncc_db_schema.sql`). This file should be included in the project for ease of setup.

6. **Configure Database Connection**:
   - Open `includes/config.php` and update the database credentials if necessary.

7. **Access the Application**:
   - Open your web browser and navigate to `http://localhost/project_root/public/index.php`.

## Usage

- **User Registration**: Navigate to the registration page to create a new account.
- **Login**: After registration, log in using your credentials.
- **Profile Management**: Update your profile information, including name, email, age, phone number, and profile picture.
- **Enrollment**: Browse available courses and enroll in units of your choice.
- **Content Access**: Explore articles and learning materials designed to enhance your educational journey.

## Author

- **Name**: Ivo Pereira
- **Email**: [ivopereiraix3@gmail.com](mailto:ivopereiraix3@gmail.com)
- **GitHub**: [perivo](https://github.com/perivo)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgements

- Thanks to the open-source community for providing invaluable tools and libraries.
- Special thanks to everyone who contributed to the development and testing of this application.

## Known Issues

- **Profile Picture Upload**: Ensure that the uploaded file meets the size and format requirements.
- **Enrollment Status Update**: Sometimes, the status may not refresh immediately; consider reloading the page.

## Future Improvements

- Implement a more robust file upload system with validation for file types and sizes.
- Enhance the admin dashboard for better user and enrollment management.
- Introduce a notification system for important updates and deadlines.

## Contribution

We welcome contributions! If you have suggestions or improvements, please fork the repository and submit a pull request.

