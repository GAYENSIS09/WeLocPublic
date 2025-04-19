document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.password-toggle')?.addEventListener('click', function(e) {
        const passwordField = this.previousElementSibling;
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    var show_picture = document.getElementById("img_voiture");
    var hiddenId = document.getElementById("hiddenId");
    var pictContainer = document.getElementsByClassName("photo-container");
    Array.from(pictContainer).forEach(element => {
        element.addEventListener('click', () => {
            const img = element.querySelector('img'); 
            const id = element.querySelector('input');
            if (img && id) {
                show_picture.src = img.src; 
                hiddenId.value = id.value;
            }
        });
    });

    var deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            if (!confirm("Voulez-vous vraiment supprimer ?")) {
                event.preventDefault();
            }
        });
    });
    var imgInput = document.getElementById('img-cars');
    if (imgInput) {
        imgInput.addEventListener('change', function() {
            if (this.dataset.preventSubmit !== "true") {
                this.form.submit();
            }
        });
    }
});