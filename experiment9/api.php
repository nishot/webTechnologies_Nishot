<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'clear_history') {
        file_put_contents('history.txt', '');
        echo json_encode(["status" => "success"]);
        exit;
    }

    if ($action === 'calculate') {
        $expr = $_POST['expression'] ?? '';
        $safe_expr = preg_replace('/[^0-9\+\-\*\/\.]/', '', $expr);

        if (empty($safe_expr)) {
            echo json_encode(["status" => "error", "message" => "Invalid expression"]);
            exit;
        }

        try {
            if (preg_match('/\/0(\.0+)?(?![\.0-9])/', $safe_expr)) {
                throw new Exception("Division by zero");
            }

            $result = @eval("return ($safe_expr);");

            if ($result === false || is_null($result)) {
                echo json_encode(["status" => "error", "message" => "Evaluation error"]);
            } else {
                $historyEntry = $safe_expr . " = " . $result;
                file_put_contents('history.txt', $historyEntry . PHP_EOL, FILE_APPEND | LOCK_EX);
                echo json_encode(["status" => "success", "result" => $result, "history" => $historyEntry]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        } catch (Error $e) {
            echo json_encode(["status" => "error", "message" => "Math Error"]);
        }
        exit;
    }
}

echo json_encode(["status" => "error", "message" => "Invalid request"]);
?>
