function showLogin(userType) {
    const loginForm = document.getElementById('login-form');
    loginForm.style.display = 'block';
    document.getElementById('user-type').value = userType;
    document.getElementById('login-title').innerText = userType === 'admin' ? 'Admin Login' : 'Student Login';
    
    setTimeout(() => {
        loginForm.style.opacity = '1';
        loginForm.style.transform = 'translateY(0)';
    }, 50);
}

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');
    
    document.addEventListener('click', function (event) {
        if (!loginForm.contains(event.target) && event.target.tagName !== 'BUTTON') {
            loginForm.style.opacity = '0';
            loginForm.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                loginForm.style.display = 'none';
            }, 300);
        }
    });

    const buttons = document.querySelectorAll('.login-section button');
    buttons.forEach(button => {
        button.addEventListener('mouseover', function () {
            this.style.transform = 'scale(1.1)';
        });
        button.addEventListener('mouseout', function () {
            this.style.transform = 'scale(1)';
        });
    });
});