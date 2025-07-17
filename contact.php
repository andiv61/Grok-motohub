<?php include 'includes/header.php'; ?>

<main>
    <h2>Контакты</h2>
    <p>Свяжитесь с нами: info@racer-motorcycles.com</p>
    <form method="post" action="contact.php">
        <label>Имя:</label>
        <input type="text" name="name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Сообщение:</label>
        <textarea name="message" required></textarea>
        <button type="submit" class="btn">Отправить</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo '<p>Сообщение отправлено!</p>';
    }
    ?>
</main>

<?php include 'includes/footer.php'; ?>