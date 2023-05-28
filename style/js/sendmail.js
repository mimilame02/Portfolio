function submitForm() {
    event.preventDefault(); // Prevents the default form submission behavior

    sendMail();
}

function sendMail(){
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
            alert("Your message sent successfully.");
        })
        .catch((err) => console.log(err));
}