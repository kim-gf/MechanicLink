<?php include 'header.php'; ?>

<main>
    <section class="mechanic-profile">
        <h2>Mechanic Profile</h2>
        <form action="update_mechanic.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="phone">Phone Number:</label><br>
            <input type="tel" id="phone" name="phone" required><br><br>
            
            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" required><br><br>
            
            <label for="experience">Experience (Years):</label><br>
            <input type="number" id="experience" name="experience" required><br><br>
            
            <label for="services">Services Offered:</label><br>
            <textarea id="services" name="services" rows="4" required></textarea><br><br>
            
            <label for="specialization">Specialization:</label><br>
            <input type="text" id="specialization" name="specialization"><br><br>
            
            <label for="certifications">Certifications:</label><br>
            <textarea id="certifications" name="certifications" rows="2"></textarea><br><br>
            
            <button type="submit">Update Profile</button>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
