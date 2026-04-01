<?php
session_start();

// 1. ĐỊNH NGHĨA HẰNG SỐ TRƯỚC (Phải đặt ở đây thì dòng dưới mới dùng được)
define('GEMINI_API_KEY', 'AIzaSyDvuFKCxo-blkjfYGynlL860mq5I5XvU40');
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent');

// 2. Reset khung chat
if (isset($_GET['clear'])) {
    $_SESSION['chat_messages'] = [];
    header("Location: chat-plugin.php"); 
    exit;
}

// 3. CẤU HÌNH API
$api_key = GEMINI_API_KEY;
$api_url = GEMINI_API_URL . "?key=" . $api_key;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $user_message = trim($_POST['message']);
    $_SESSION['chat_messages'][] = ['role' => 'user', 'text' => $user_message];

    $contents = [];
    // Lọc lịch sử tin nhắn
    if (!empty($_SESSION['chat_messages'])) {
        $recent_messages = array_slice($_SESSION['chat_messages'], -10);
        foreach ($recent_messages as $msg) {
            if (!empty($msg['text']) && strpos($msg['text'], 'Lỗi:') === false) {
                $contents[] = [
                    "role" => ($msg['role'] === 'user') ? 'user' : 'model',
                    "parts" => [["text" => $msg['text']]]
                ];
            }
        }
    }

    if (empty($contents)) {
        header("Location: chat-plugin.php");
        exit;
    }

    // Gửi cURL
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
    // curl_close($ch);

    if ($http_code === 200) {
        $result = json_decode($response, true);
        $ai_text = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi';
        $_SESSION['chat_messages'][] = ['role' => 'bot', 'text' => $ai_text];
    } else {
        $err_data = json_decode($response, true);
        $msg_err = $err_data['error']['message'] ?? "Mã lỗi: $http_code";
        $_SESSION['chat_messages'][] = ['role' => 'bot', 'text' => "Lỗi: " . $msg_err];
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
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        #chat-container {
            width: 100%;
            max-width: 400px;
            height: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        h2 {
            background: #007bff;
            color: white;
            margin: 0;
            padding: 15px;
            text-align: center;
            font-size: 1.1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .clear-btn {
            font-size: 12px;
            color: #eee;
            text-decoration: none;
            border: 1px solid #eee;
            padding: 2px 8px;
            border-radius: 10px;
        }

        #chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #fafafa;
        }

        .msg {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 85%;
            font-size: 14px;
            line-height: 1.5;
        }

        .user {
            align-self: flex-end;
            background: #007bff;
            color: white;
            border-bottom-right-radius: 4px;
        }

        .bot {
            align-self: flex-start;
            background: #e4e6eb;
            color: #333;
            border-bottom-left-radius: 4px;
        }

        .form-container {
            padding: 15px;
            background: white;
            border-top: 1px solid #eee;
        }

        form {
            display: flex;
            gap: 8px;
        }

        input {
            flex: 1;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 25px;
            outline: none;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="chat-container">
        <h2>
            <span>Tôi là Hoài Păng Păng</span>
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
                echo '<div class="msg bot">Xin chào! Tôi có thể giúp gì cho bạn về đồng hồ Watch Hub?</div>';
            }
            ?>
        </div>

        <div class="form-container">
            <form method="POST">
                <input type="text" name="message" placeholder="Hỏi tôi về sản phẩm..." required autofocus autocomplete="off">
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