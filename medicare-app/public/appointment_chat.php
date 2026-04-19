<?php
include 'components/header.php';
require_once __DIR__ . '/../backend/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$appointmentId = $_GET['appointment_id'] ?? 0;

// Security: Check access and fetch details
$stmt = $conn->prepare("
    SELECT a.*, u.fullname as patient_name, d.name as doctor_name 
    FROM appointments a 
    JOIN users u ON a.user_id = u.id 
    JOIN doctors d ON a.doctor_id = d.id 
    WHERE a.id = ?
");
$stmt->execute([$appointmentId]);
$appointment = $stmt->fetch();

if (!$appointment || ($appointment['user_id'] != $_SESSION['user_id'] && $appointment['doctor_id'] != $_SESSION['user_id'])) {
    echo "<div class='container py-5 text-center'><h1>Unauthorized</h1><p>You do not have access to this conversation.</p></div>";
    include 'components/footer.php';
    exit();
}

$otherParticipant = ($_SESSION['role'] === 'doctor') ? $appointment['patient_name'] : $appointment['doctor_name'];
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Chat Hub Header -->
            <div class="bento-card p-4 mb-4 bg-primary-light d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-3 me-3">
                        <i class="fas fa-user-md fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?php echo htmlspecialchars($otherParticipant); ?></h4>
                        <span class="small text-muted">Appointment: <?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?> at <?php echo $appointment['appointment_time']; ?></span>
                    </div>
                </div>
                <a href="dashboard.php" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Return to Dashboard</a>
            </div>

            <!-- Chat Container -->
            <div class="bento-card p-0 overflow-hidden shadow-lg border-0" style="height: 600px; display: flex; flex-direction: column;">
                <!-- Message Thread -->
                <div id="chatThread" class="p-4 overflow-y-auto bg-white flex-grow-1" style="background-image: radial-gradient(#e2e8f0 1px, transparent 1px); background-size: 20px 20px;">
                    <!-- Messages will be injected here -->
                </div>

                <!-- Input Area -->
                <div class="p-4 bg-light border-top">
                    <form id="chatForm" class="d-flex gap-2">
                        <input type="text" id="messageInput" class="form-control rounded-pill border-0 px-4 py-3 shadow-none" placeholder="Type your message here..." autocomplete="off">
                        <button type="submit" class="btn btn-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.msg-bubble {
    max-width: 75%;
    padding: 12px 18px;
    border-radius: 20px;
    margin-bottom: 15px;
    font-size: 0.95rem;
    position: relative;
    line-height: 1.5;
}

.msg-sent {
    background-color: var(--primary, #14b8a6);
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}

.msg-received {
    background-color: #f1f5f9;
    color: #1e293b;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}

.timestamp {
    font-size: 0.7rem;
    opacity: 0.6;
    margin-top: 4px;
    display: block;
}
</style>

<script>
let lastMessageId = 0;
const appointmentId = <?php echo $appointmentId; ?>;
const userId = <?php echo $_SESSION['user_id']; ?>;
const chatThread = document.getElementById('chatThread');

function appendMessage(msg) {
    // Standardize comparison to ensure both side chatting is visible
    const isSent = parseInt(msg.sender_id) === parseInt(userId);
    const div = document.createElement('div');
    div.className = `d-flex flex-column ${isSent ? 'align-items-end' : 'align-items-start'} mb-3`;
    
    const bubble = document.createElement('div');
    bubble.className = `msg-bubble ${isSent ? 'msg-sent' : 'msg-received'}`;
    bubble.textContent = msg.content;
    
    const time = document.createElement('span');
    time.className = 'timestamp';
    time.textContent = new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    
    bubble.appendChild(time);
    div.appendChild(bubble);
    chatThread.appendChild(div);
    chatThread.scrollTop = chatThread.scrollHeight;
}

function fetchMessages() {
    fetch(`api_chat.php?action=fetch&appointment_id=${appointmentId}&last_id=${lastMessageId}`)
        .then(res => res.json())
        .then(data => {
            if (Array.isArray(data)) {
                data.forEach(msg => {
                    appendMessage(msg);
                    lastMessageId = Math.max(lastMessageId, msg.id);
                });
            }
        });
}

document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const content = input.value.trim();
    if (!content) return;

    fetch('api_chat.php?action=send', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ appointment_id: appointmentId, content: content })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            fetchMessages(); // Immediately pull new messages
        }
    });
});

// Initial load and polling
fetchMessages();
setInterval(fetchMessages, 3000); // Poll every 3 seconds
</script>

<?php include 'components/footer.php'; ?>
