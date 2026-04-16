<?php
session_start();

// 1. ĐỊNH NGHĨA HẰNG SỐ
define('GEMINI_API_KEY', 'AIzaSyCMKHCnWpwUA5_smCGnu16rFityhvObNqo');
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent');

// 2. HÀM HỖ TRỢ TRUY VẤN DỮ LIỆU (DATABASE LOGIC)
function getKeywords($text) {
    $text = mb_strtolower($text, 'UTF-8');
    // Loại bỏ các từ thừa phổ biến trong câu hỏi tiếng Việt
    $stopWords = ['là', 'của', 'và', 'tìm', 'cho', 'hỏi', 'có', 'không', 'giá', 'bao', 'nhiêu', 'tôi', 'muốn', 'mua', 'cửa', 'hàng', 'shop'];
    $words = explode(' ', $text);
    $keywords = array_filter($words, function($word) use ($stopWords) {
        return !in_array($word, $stopWords) && mb_strlen($word, 'UTF-8') > 1;
    });
    return array_values($keywords);
}

function searchProducts($user_message) {
    $keywords = getKeywords($user_message);
    if (empty($keywords)) return "";
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "watch_hub"; 

    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) return "";

    // Thiết lập utf8mb4 để không lỗi font tiếng Việt khi query
    $conn->set_charset("utf8mb4");

    $conditions = [];
    foreach ($keywords as $key) {
  
        $conditions[] = "ten_san_pham LIKE '%" . $conn->real_escape_string($key) . "%'";
    }
    
    // Câu lệnh SQL truy vấn vào bảng san_pham
    $sql = "SELECT ten_san_pham, gia_san_pham FROM san_phams WHERE " . implode(' OR ', $conditions) . " LIMIT 3";
    $result = $conn->query($sql);
    
    $foundData = "";
    if ($result && $result->num_rows > 0) {
        $foundData = " Dữ liệu thực tế từ kho: ";
        while($row = $result->fetch_assoc()) {
            // Sửa lại chỗ này để khớp với tên cột ten_sp và gia_sp
            $foundData .= "[" . $row['ten_san_pham'] . " - Giá: " . number_format($row['gia_san_pham']) . "đ], ";
        }
    }
    $conn->close();
    return $foundData;
}

// 3. XỬ LÝ RESET CHAT
if (isset($_GET['clear'])) {
    $_SESSION['chat_messages'] = [];
    header("Location: chat-plugin.php"); 
    exit;
}

// 4. XỬ LÝ GỬI TIN NHẮN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $user_raw_message = trim($_POST['message']);
    
    // Lưu tin nhắn gốc của người dùng vào session để hiển thị trên UI
    $_SESSION['chat_messages'][] = ['role' => 'user', 'text' => $user_raw_message];

    // Truy vấn database để lấy context
    $db_info = searchProducts($user_raw_message);

    $contents = [];
    if (!empty($_SESSION['chat_messages'])) {
        $recent_messages = array_slice($_SESSION['chat_messages'], -10);
        foreach ($recent_messages as $index => $msg) {
            $text_content = $msg['text'];

            // Nếu là tin nhắn mới nhất của User, ta đính kèm thông tin DB vào để AI đọc
            if ($index === count($recent_messages) - 1 && $msg['role'] === 'user') {
                if (!empty($db_info)) {
                    $text_content .= "\n(Hệ thống: Hãy dựa vào thông tin sản phẩm này để trả lời khách một cách tự nhiên: " . $db_info . ")";
                }
            }

            $contents[] = [
                "role" => ($msg['role'] === 'user') ? 'user' : 'model',
                "parts" => [["text" => $text_content]]
            ];
        }
    }

    // Gửi cURL tới Gemini
    $api_url = GEMINI_API_URL . "?key=" . GEMINI_API_KEY;
    $ch = curl_init($api_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(["contents" => $contents]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 20
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        $result = json_decode($response, true);
        $ai_text = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tôi không tìm thấy câu trả lời.';
        $_SESSION['chat_messages'][] = ['role' => 'bot', 'text' => $ai_text];
    } else {
        $err_data = json_decode($response, true);
        $msg_err = $err_data['error']['message'] ?? "Mã lỗi: $http_code";
        $_SESSION['chat_messages'][] = ['role' => 'bot', 'text' => "Lỗi kết nối AI: " . $msg_err];
    }

    header("Location: chat-plugin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI ChatBot - Watch Hub</title>
    <style>
    /* 1. RESET & CĂN GIỮA */
    * {
        box-sizing: border-box;
    }

    body { 
        font-family: 'Inter', 'Segoe UI', sans-serif; 
        display: flex; 
        justify-content: center; 
        align-items: end; 
        height: 100vh; 
        margin: 0; 
        padding: 10px;
    }

    /* 2. KHUNG CHAT CHÍNH - ĐÃ THU NHỎ */
    #chat-container { 
        width: 100%; 
        /* max-width: 360px; */
        height: 100vh; 
        /* max-height: 580px;  */
        background: #ffffff; 
        border-radius: 18px; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); 
        display: flex; 
        flex-direction: column; 
        overflow: hidden; 
        border: 1px solid #e0e0e0;
    }

    /* 3. TIÊU ĐỀ (HEADER) */
    h2 { 
        background: #007bff; 
        color: white; 
        margin: 0; 
        padding: 12px 15px; /* Giảm padding cho thanh mảnh hơn */
        font-size: 1rem; /* Chữ nhỏ lại một chút */
        display: flex; 
        justify-content: space-between; 
        align-items: center;
    }

    .clear-btn { 
        font-size: 10px; 
        color: #fff; 
        text-decoration: none; 
        border: 1px solid rgba(255,255,255,0.4); 
        padding: 3px 8px; 
        border-radius: 10px; 
        background: rgba(255,255,255,0.1);
    }

    /* 4. NỘI DUNG CHAT */
    #chat-box { 
        flex: 1; 
        padding: 12px; 
        overflow-y: auto; 
        display: flex; 
        flex-direction: column; 
        gap: 10px; 
        background: #fdfdfd; 
    }

    /* Tùy chỉnh thanh cuộn */
    #chat-box::-webkit-scrollbar { width: 4px; }
    #chat-box::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

    /* 5. TIN NHẮN */
    .msg { 
        padding: 8px 12px; 
        border-radius: 14px; 
        max-width: 88%; 
        font-size: 13px; /* Chữ nhỏ lại để phù hợp khung nhỏ */
        line-height: 1.4; 
        word-wrap: break-word;
    }

    .user { 
        align-self: flex-end; 
        background: #007bff; 
        color: white; 
        border-bottom-right-radius: 2px; 
    }

    .bot { 
        align-self: flex-start; 
        background: #f1f3f5; 
        color: #333; 
        border-bottom-left-radius: 2px; 
        border: 1px solid #eee;
    }

    /* 6. Ô NHẬP LIỆU (FOOTER) */
    .form-container { 
        padding: 10px 12px; 
        background: white; 
        border-top: 1px solid #f0f0f0; 
    }

    form { 
        display: flex; 
        gap: 6px; 
    }

    input { 
        flex: 1; 
        border: 1px solid #e0e0e0; 
        padding: 8px 15px; 
        border-radius: 20px; 
        outline: none; 
        font-size: 13px;
    }

    button { 
        background: #007bff; 
        color: white; 
        border: none; 
        padding: 0 15px; 
        border-radius: 20px; 
        cursor: pointer; 
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    button:hover { background: #0056b3; }
</style>
</head>
<body>
    <div id="chat-container">
        <h2>
            <span>Chatbot</span>
            <a href="?clear=1" class="clear-btn">Làm mới</a>
        </h2>

        <div id="chat-box">
            <?php
            if (!empty($_SESSION['chat_messages'])) {
                foreach ($_SESSION['chat_messages'] as $message) {
                    $class = ($message['role'] === 'user') ? 'user' : 'bot';
                    echo '<div class="msg ' . $class . '">' . nl2br(htmlspecialchars($message['text'])) . '</div>';
                }
            } else {
                echo '<div class="msg bot">Xin chào! Tôi là trợ lý Watch Hub. Bạn cần tìm mẫu đồng hồ nào hôm nay?</div>';
            }
            ?>
        </div>

        <div class="form-container">
            <form method="POST">
                <input type="text" name="message" placeholder="Hỏi tôi về đồng hồ Rolex, Casio..." required autofocus autocomplete="off">
                <button type="submit">Gửi</button>
            </form>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>
</html>