// ===================================
// Contact Form Handling with AJAX
// ===================================
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent default form submission

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            // Show loading state
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;

            // Remove any existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            try {
                // Get form data
                const formData = new FormData(contactForm);

                // Send AJAX request
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Show success message
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success';
                    successAlert.textContent = data.message;
                    contactForm.parentElement.insertBefore(successAlert, contactForm);

                    // Reset form
                    contactForm.reset();

                    // Scroll to success message
                    successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                    // Remove alert after 5 seconds
                    setTimeout(() => {
                        successAlert.remove();
                    }, 5000);
                } else {
                    // Show error message
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-error';

                    if (data.errors) {
                        const errorList = document.createElement('ul');
                        errorList.style.margin = '0';
                        errorList.style.paddingLeft = '20px';
                        Object.values(data.errors).forEach(errorArray => {
                            errorArray.forEach(error => {
                                const li = document.createElement('li');
                                li.textContent = error;
                                errorList.appendChild(li);
                            });
                        });
                        errorAlert.appendChild(errorList);
                    } else {
                        errorAlert.textContent = data.message || 'An error occurred. Please try again.';
                    }

                    contactForm.parentElement.insertBefore(errorAlert, contactForm);
                }
            } catch (error) {
                console.error('Form submission error:', error);
                // Show error message
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-error';
                errorAlert.textContent = 'Sorry, there was an error sending your message. Please try again or email directly at tloomis323@gmail.com.';
                contactForm.parentElement.insertBefore(errorAlert, contactForm);
            } finally {
                // Restore button state
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});
