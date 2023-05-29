function submitForm() {
    event.preventDefault(); // Prevents the default form submission behavior

    if (validateForm()) {
        sendMail();
    }
}

function validateForm() {
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const messageInput = document.getElementById("message");

    if (nameInput.value.trim() === "") {
        alert("Please enter your name.");
        nameInput.focus();
        return false;
    }

    if (emailInput.value.trim() === "") {
        alert("Please enter your email.");
        emailInput.focus();
        return false;
    }

    // Email format validation using regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
        alert("Please enter a valid email address.");
        emailInput.focus();
        return false;
    }

    if (messageInput.value.trim() === "") {
        alert("Please enter your message.");
        messageInput.focus();
        return false;
    }

    return true;
}

function sendMail() {
    var params = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        message: document.getElementById("message").value,
    };

    const serviceID = "service_yvqq4me";
    const templateID = "template_ffkujd4";

    emailjs
        .send(serviceID, templateID, params)
        .then((res) => {
            document.getElementById("name").value = "";
            document.getElementById("email").value = "";
            document.getElementById("message").value = "";
            console.log(res);
            alert("Your message was sent successfully.");
        })
        .catch((err) => console.log(err));
}