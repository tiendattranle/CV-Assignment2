document.addEventListener('DOMContentLoaded', function() {
    // Get all form inputs
    const formInputs = document.querySelectorAll('#resumeForm input, #resumeForm textarea, #resumeForm select');
    
    // Add event listeners to all form inputs
    formInputs.forEach(input => {
        input.addEventListener('input', updatePreview);
    });
    
    // Add event listener to template selector
    const templateSelector = document.getElementById('templateSelector');
    templateSelector.addEventListener('change', switchTemplate);
    
    // Add event listener for profile image upload
    document.getElementById('profileImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Create a preview in all template previews
            const reader = new FileReader();
            reader.onload = function(e) {
                // Replace placeholder divs with actual images
                const placeholders = document.querySelectorAll('.profile-image-placeholder');
                placeholders.forEach(placeholder => {
                    placeholder.style.backgroundImage = `url(${e.target.result})`;
                    placeholder.style.backgroundSize = 'cover';
                    placeholder.style.backgroundPosition = 'center';
                });
            }
            reader.readAsDataURL(file);
            
            // Update the hidden image field with the filename
            document.getElementById('image').value = file.name;
        }
    });
    
    // Initialize the preview with any existing values
    updateAllPreviews();
    
    // Function to update preview when inputs change
    function updatePreview(event) {
        const input = event.target;
        const inputId = input.id;
        const previewId = 'preview' + inputId.charAt(0).toUpperCase() + inputId.slice(1);
        
        // Get all elements that need to be updated (could be in multiple templates)
        const previewElements = document.querySelectorAll('#' + previewId);
        
        previewElements.forEach(element => {
            if (input.value) {
                // Format dates nicely
                if (input.type === 'date') {
                    const date = new Date(input.value);
                    const options = { year: 'numeric', month: 'long', day: 'numeric' };
                    element.textContent = date.toLocaleDateString('en-US', options);
                } 
                // Handle multi-line text in textareas
                else if (input.tagName === 'TEXTAREA') {
                    element.innerHTML = input.value.replace(/\n/g, '<br>');
                }
                // Handle all other input types
                else {
                    element.textContent = input.value;
                }
            } else {
                // Reset to default placeholder text if field is empty
                element.textContent = getDefaultText(inputId);
            }
        });
    }
    
    // Function to switch between CV templates
    function switchTemplate() {
        // Hide all templates
        const templates = document.querySelectorAll('.template-preview');
        templates.forEach(template => {
            template.style.display = 'none';
        });
        
        // Show the selected template
        const selectedTemplate = document.getElementById(templateSelector.value);
        if (selectedTemplate) {
            selectedTemplate.style.display = 'block';
        }
    }
    
    // Function to update all preview elements at once
    function updateAllPreviews() {
        formInputs.forEach(input => {
            const inputId = input.id;
            const previewId = 'preview' + inputId.charAt(0).toUpperCase() + inputId.slice(1);
            
            const previewElements = document.querySelectorAll('#' + previewId);
            
            previewElements.forEach(element => {
                if (input.value) {
                    if (input.type === 'date') {
                        const date = new Date(input.value);
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        element.textContent = date.toLocaleDateString('en-US', options);
                    } else if (input.tagName === 'TEXTAREA') {
                        element.innerHTML = input.value.replace(/\n/g, '<br>');
                    } else {
                        element.textContent = input.value;
                    }
                } else {
                    element.textContent = getDefaultText(inputId);
                }
            });
        });
    }
    
    // Function to provide default placeholder text for empty fields
    function getDefaultText(fieldId) {
        const defaultTexts = {
            'name': 'Your Name',
            'address': 'Your Address',
            'phone': '123-456-7890',
            'email': 'your.email@example.com',
            'birthday': 'Your Birthday',
            'gender': 'Your Gender',
            'language': 'Your Languages',
            'skill': 'Your Skills',
            'companyname': 'Company Name',
            'cposition': 'Position',
            'cstartdate': 'Start Date',
            'varsityname': 'Your University',
            'cgpa': 'CGPA',
            'varsitypyear': 'Year',
            'collegename': 'Your College',
            'hscgpa': 'HSC GPA',
            'clgpyear': 'Year',
            'schoolname': 'Your School',
            'sscgpa': 'SSC GPA',
            'sclpyear': 'Year'
        };
        
        return defaultTexts[fieldId] || 'Information';
    }
});