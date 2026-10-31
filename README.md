# ONLINE-DOCTOR-APPOINTMENT-SYSTEM
ONLINE-DOCTOR-APPOINTMENT-SYSTEM

# Online Doctor Appointment System

## 1. Project Description

The **Online Doctor Appointment System** is a web-based application designed to simplify and improve the process of booking and managing medical appointments.

The system provides a centralized platform connecting patients, doctors, and administrators. Patients can register, log in, view available doctors, book appointments, and check their appointment history.

Doctors can view their scheduled appointments and relevant patient details, while administrators can manage doctor profiles, schedules, patient records, and appointment information.

An additional feature is a Python-based AI chatbot that assists patients by answering common healthcare-related queries, guiding them through the appointment booking process, and suggesting suitable doctors.

## 2. Project Objectives

- To provide an easy and convenient online appointment booking facility.
- To reduce manual paperwork and waiting time.
- To maintain centralized patient and doctor information.
- To provide separate access for patients, doctors, and administrators.
- To integrate an AI chatbot for basic healthcare-related assistance.
- To improve appointment scheduling and management.
- To provide a user-friendly and responsive web interface.

## 3. Features

### Patient Module
- Patient registration and login.
- View available doctors.
- Check doctor details and specializations.
- Book doctor appointments.
- View upcoming and previous appointments.
- Access AI chatbot assistance.

### Doctor Module
- View scheduled appointments.
- Access relevant patient information.
- Review appointment schedules.
- Manage availability where supported.

### Admin Module
- Manage doctor profiles.
- Manage patient information.
- Manage doctor schedules.
- View and manage appointment records.
- Monitor overall system activities.

### AI Chatbot Module
- Answer frequently asked questions.
- Provide appointment booking guidance.
- Suggest suitable doctors based on user queries.
- Provide general healthcare-related information.

**Note:** The chatbot provides informational assistance only. It does not replace professional medical advice, diagnosis, or emergency healthcare services.

## 4. Technologies Used

| Technology | Purpose |
|---|---|
| HTML | Structure of web pages |
| CSS | Styling and layout |
| PHP | Backend development |
| MySQL | Database management |
| Python | AI chatbot development |
| Bootstrap | Responsive user interface |
| Flask / FastAPI | Python chatbot API integration |
| XAMPP / WAMP | Local development environment |
| Visual Studio Code | Code development and editing |

## 5. System Requirements

### Hardware Requirements
- Processor: Intel i3 or equivalent.
- RAM: Minimum 4 GB.
- Storage: Minimum 10 GB free space.
- Internet connection.
- Keyboard and mouse.

### Software Requirements
- Windows, Linux, or macOS.
- PHP.
- MySQL.
- Apache Server.
- Python.
- Visual Studio Code.
- Modern web browser.
- XAMPP or WAMP.

## 6. Project Modules

The system consists of the following main modules:

1. **Authentication Module:** Handles patient registration and login.
2. **Patient Module:** Allows patients to view doctors and book appointments.
3. **Doctor Module:** Provides appointment and schedule information.
4. **Admin Module:** Manages doctors, patients, schedules, and appointments.
5. **Appointment Module:** Handles appointment booking and availability checking.
6. **AI Chatbot Module:** Provides automated responses and doctor suggestions.
7. **Database Module:** Stores and manages system information.

## 7. Installation and Setup

Follow these steps to run the project locally.

### Step 1: Install Required Software

Install the following:
- XAMPP or WAMP.
- PHP.
- MySQL.
- Python.
- Visual Studio Code.

### Step 2: Download or Clone the Project

Clone the project repository:

```bash
git clone YOUR_GITHUB_REPOSITORY_URL
```

Alternatively, download and extract the project ZIP file.

### Step 3: Configure the Project

Place the PHP project folder inside the XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\OnlineDoctorAppointment
```

### Step 4: Start XAMPP

1. Open XAMPP Control Panel.
2. Start Apache.
3. Start MySQL.

### Step 5: Configure the Database

1. Open phpMyAdmin.
2. Create a MySQL database for the project.
3. Import the project's SQL database file, if available.
4. Configure the database connection details in the PHP configuration file.

### Step 6: Configure Python Chatbot

Install the required Python packages listed in the project's requirements file.

```bash
pip install -r requirements.txt
```

Run the chatbot service using its configured Python entry point.

### Step 7: Run the Application

Open your browser and enter:

```text
http://localhost/OnlineDoctorAppointment/
```

The application should now be accessible locally.

*Note: Database names, configuration filenames, chatbot startup commands, and folder paths must be adjusted according to the actual source code.*

## 8. Working of the System

The basic working process is:

1. The patient opens the website.
2. The patient registers or logs into the system.
3. The patient views available doctors.
4. The patient selects a doctor and preferred appointment slot.
5. The system checks doctor availability.
6. The appointment request is processed.
7. The appointment information is stored in the MySQL database.
8. The doctor can view scheduled appointments.
9. The administrator manages doctors, patients, and appointment records.
10. The AI chatbot provides additional assistance to patients.

## 9. Advantages

- Saves time and reduces manual effort.
- Simplifies appointment scheduling.
- Provides centralized data management.
- Improves coordination between patients and doctors.
- Reduces scheduling conflicts through availability validation.
- Provides automated assistance through an AI chatbot.
- Offers convenient access through a web browser.

## 10. Future Enhancements

The project can be enhanced with the following features:

- Online video consultations.
- Online payment integration.
- SMS and email appointment reminders.
- Mobile application support.
- Electronic medical record integration.
- Improved multilingual AI chatbot.
- Advanced doctor recommendation system.
- Appointment analytics and reports.

## 11. Conclusion

The Online Doctor Appointment System provides a convenient and organized solution for managing healthcare appointments through a web-based platform. It combines PHP, HTML, CSS, MySQL, and Python-based AI chatbot technology to simplify appointment booking and improve communication between patients, doctors, and administrators.

The project demonstrates the practical application of web development, database management, and artificial intelligence in the healthcare sector.

## 12. Author

**Project Name:** Online Doctor Appointment System  
**Student Name:** Grishma Manohar Sawant  
**Course:** Bachelor of Science in Computer Science  
**Semester:** V  
**Academic Year:** 2026–2027  
**College:** Sonopant Dandekar Arts, V.S. Apte Commerce and M.H. Mehta Science College, Palghar  
**University:** University of Mumbai

## 13. License

This project is developed for academic and educational purposes.
