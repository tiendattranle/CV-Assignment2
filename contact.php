<main style="background-image: url('images/contact.jpg'); background-size: cover; background-position: center;">
    <div class="contact-container">
            <h1>Contact Us</h1>
            <p>We would love to hear from you! Fill out the form below and we'll get back to you as soon as possible.</p>
            <!-- Google Map Section -->
    <div class="flex-container" style="display: flex; flex-wrap: wrap; gap: 2vw; justify-content: center; align-items: flex-start;">
        <div class="map-container" style="flex: 1; min-width: 300px; max-width: 600px;">
            <h4>Find Us Here</h4>
            <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.692574874258!2d106.6584303153346!3d10.76262269233164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec1b5d6e0b5%3A0x4f9b5b8e9b7c8e0!2zMjY4IEzDqiBUaMawxqFuZyBLaeG7h3QsIFBoxrDhu51uZyAxMCwgUXXhuq1uIDEsIEjhu5MgQ2jDrSBUaOG7iywgVMOibiBCw6xuaCwgVmnhu4d0IE5hbQ!5e0!3m2!1sen!2s!4v1614312345678!5m2!1sen!2s" 
            width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>

        <div class="contact-box" style="flex: 1; min-width: 300px; max-width: 600px;">
            <div class="contact-container">
                <h3>Fill the Form</h3>
                <form id="contactForm" onsubmit="return validateForm()">
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
    </div>

    </div>

</main>

