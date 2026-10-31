@echo off
TITLE eDoc Medical System - Startup Script
cls
echo ======================================================
echo           eDoc Medical Appointment System
echo ======================================================
echo.

:: Check if XAMPP is running (Basic check for Apache)
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%"=="1" (
    echo [WARNING] Apache is not running! 
    echo Please start Apache and MySQL from XAMPP Control Panel.
    echo.
    pause
)

echo [1/3] Starting Medical AI Server (Python)...
:: Try python, then python3
python --version >nul 2>&1
if %errorlevel% == 0 (
    start /min cmd /c "python app.py"
    echo Python server started.
) else (
    python3 --version >nul 2>&1
    if %errorlevel% == 0 (
        start /min cmd /c "python3 app.py"
        echo Python3 server started.
    ) else (
        echo [ERROR] Python not found! Please install Python to use AI features.
    )
)

echo [2/3] Opening eDoc Web Interface...
start http://localhost/edoc-doctor-appointment-system-main/index.html

echo [3/3] Checking Environment...
if not exist ".env" (
    echo [ERROR] .env file missing! Please recreate it.
) else (
    echo [SUCCESS] Environment configuration detected.
)

echo.
echo ======================================================
echo System is now active. 
echo Keep this window open or close it as needed.
echo ======================================================
pause
