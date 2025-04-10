<main style="background-image: url('images/contact.jpg'); background-size: cover; background-position: center;">
        <div class="contact-container">
            <h1>Contact Us</h1>
            <p>We would love to hear from you! Fill out the form below and we'll get back to you as soon as possible.</p>
        </div>
        <div class="contact-box">
            <div class="contact-container">
                <h3>Fill the Form</h3>
                <form id="contactForm" onsubmit="return validateForm()"></form>
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" id="name" placeholder="Enter your Name" required>
                    </div>

                    <div class="input-group">
                        <label>Phone</label>
                        <input type="text" id="phone" placeholder="+8412345678" required>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" id="email" placeholder="abc@gmail.com" required>
                    </div>

                    <label>Message</label>
                    <textarea rows="10" id="message" placeholder="Enter your Message" required></textarea>
                    <button type="submit">SEND</button>
                </form>
            </div>
        </div>
</main>
    