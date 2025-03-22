<?php
// admin/reservations.php - Reservations management page for admin
session_start();
require '../db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}


// Process reservation actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept'])) {
        $reservation_id = intval($_POST['reservation_id']);
        // Update reservation status to "Accepted"
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'Accepted' WHERE id = ?");
        $stmt->execute([$reservation_id]);
    } elseif (isset($_POST['cancel'])) {
        $reservation_id = intval($_POST['reservation_id']);
        // Update reservation status to "Cancelled"
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'Cancelled' WHERE id = ?");
        $stmt->execute([$reservation_id]);
    } elseif (isset($_POST['delete'])) {
        $reservation_id = intval($_POST['reservation_id']);
        // Delete reservation record
        $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->execute([$reservation_id]);
    }
    header("Location: reservations.php");
    exit;
}
include 'navbar.php';
// Retrieve all reservations ordered by date and time
$stmt = $pdo->query("SELECT * FROM reservations ORDER BY reservation_date DESC, reservation_time DESC");
$reservations = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reservations Management</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="container mx-auto py-4">
        <h1 class="text-3xl font-bold mb-4">Reservations</h1>
        <?php if (empty($reservations)): ?>
            <p>No reservations found.</p>
        <?php else: ?>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo htmlspecialchars($reservation['name']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['email']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['phone']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['reservation_date']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['reservation_time']); ?></td>
                        <td><?php echo isset($reservation['status']) ? htmlspecialchars($reservation['status']) : 'Pending'; ?></td>
                        <td><?php echo htmlspecialchars($reservation['created_at']); ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                <?php if (!isset($reservation['status']) || $reservation['status'] !== 'Accepted'): ?>
                                <button type="submit" name="accept" class="btn btn-sm btn-success">Accept</button>
                                <?php endif; ?>
                                <?php if (!isset($reservation['status']) || $reservation['status'] !== 'Cancelled'): ?>
                                <button type="submit" name="cancel" class="btn btn-sm btn-warning">Cancel</button>
                                <?php endif; ?>
                                <button type="submit" name="delete" class="btn btn-sm btn-error">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
