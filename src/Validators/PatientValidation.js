class PatientValidator {
    constructor() {
        this.validations = {
            'email': {
                regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email address'
            },
            'contact_number': {
                regex: /^\+?[\d\s-]{10,}$/,
                message: 'Please enter a valid phone number'
            },
            'emergency_contact_number': {
                regex: /^\+?[\d\s-]{10,}$/,
                message: 'Please enter a valid emergency contact number'
            },
            'first_name': {
                regex: /^[a-zA-Z]{2,}$/,
                message: 'First name must contain only letters and be at least 2 characters'
            },
            'last_name': {
                regex: /^[a-zA-Z]{2,}$/,
                message: 'Last name must contain only letters and be at least 2 characters'
            },
            'middle_name': {
                regex: /^[a-zA-Z]{2,}$/,
                message: 'Middle name must contain only letters and be at least 2 characters',
                optional: true
            },
            'date_of_birth': {
                regex: /^\d{4}-\d{2}-\d{2}$/,
                message: 'Please enter a valid date'
            },
            'gender': {
                required: true,
                message: 'Please select a gender'
            },
            'address': {
                minLength: 5,
                message: 'Address must be at least 5 characters'
            },
            'medical_history': {
                optional: true,
                minLength: 0,
                message: 'Medical history is optional'
            },
            'current_medications': {
                optional: true,
                minLength: 0,
                message: 'Current medications is optional'
            },
            'emergency_contact_name': {
                regex: /^[a-zA-Z\s]{2,}$/,
                message: 'Emergency contact name must contain only letters and be at least 2 characters'
            }
        };

        this.initializeValidators();

        // Add form submission validation
        const forms = document.querySelectorAll('form[action*="update"], form[action*="create"]');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                let hasErrors = false;
                
                Object.keys(this.validations).forEach(fieldId => {
                    const input = document.getElementById(fieldId);
                    if (input) {
                        this.validateField(input, this.validations[fieldId]);
                        if (input.classList.contains('is-invalid')) {
                            hasErrors = true;
                        }
                    }
                });

                if (!hasErrors) {
                    form.submit();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please correct the errors before submitting.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    }

    initializeValidators() {
        Object.keys(this.validations).forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input) {
                // Add blur event listener for final validation
                input.addEventListener('blur', () => {
                    this.validateField(input, this.validations[fieldId]);
                });

                // Add input event listener for real-time validation
                input.addEventListener('input', () => {
                    // Always validate on input
                    this.validateField(input, this.validations[fieldId]);
                });

                // Initial validation for pre-filled fields
                if (input.value) {
                    this.validateField(input, this.validations[fieldId]);
                }
            }
        });
    }

    clearValidation(input) {
        input.classList.remove('is-valid', 'is-invalid');
        let feedback = input.nextElementSibling;
        if (feedback && (feedback.classList.contains('valid-feedback') || 
                        feedback.classList.contains('invalid-feedback'))) {
            feedback.remove();
        }
    }

    updateValidationUI(input, isValid, message) {
        let feedback = input.nextElementSibling;
        if (!feedback || !feedback.classList.contains('validation-feedback')) {
            feedback = document.createElement('div');
            feedback.className = 'validation-feedback';
            input.parentNode.insertBefore(feedback, input.nextSibling);
        }

        input.classList.toggle('is-valid', isValid);
        input.classList.toggle('is-invalid', !isValid);
        feedback.className = `validation-feedback ${isValid ? 'valid' : 'invalid'}-feedback d-block`;
        feedback.textContent = isValid ? 'Looks good!' : message;
    }

    validateField(input, rule) {
        // Skip validation if field is optional and empty
        if (rule.optional && !input.value) {
            this.clearValidation(input);
            return;
        }

        let isValid = true;

        // Check different validation types
        if (rule.regex) {
            isValid = rule.regex.test(input.value);
        } else if (rule.minLength !== undefined) {
            isValid = input.value.length >= rule.minLength;
        } else if (rule.required) {
            isValid = input.value.trim() !== '';
        }

        // Show validation result
        this.updateValidationUI(input, isValid, rule.message);
    }
}

// Initialize validation when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new PatientValidator();
});