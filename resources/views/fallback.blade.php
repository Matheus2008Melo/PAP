<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeAreSchool - Em Manutenção</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        
        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .status {
            padding: 15px;
            background: #f7fafc;
            border-radius: 10px;
            margin: 20px 0;
            font-family: monospace;
            text-align: left;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>WeAreSchool</h1>
        <p>Estamos a configurar o sistema. Por favor, aguarde alguns instantes.</p>
        
        <div class="status">
            <strong>Status do Sistema:</strong><br>
            <span id="status">A verificar...</span>
        </div>
        
        <a href="/system-check" class="btn">Verificar Sistema</a>
        <a href="/" class="btn" style="background: #48bb78; margin-left: 10px;">Tentar Novamente</a>
    </div>
    
    <script>
        // Verificar status do sistema
        fetch('/system-check')
            .then(response => response.json())
            .then(data => {
                document.getElementById('status').innerHTML = 
                    `✅ Sistema: ${data.status}<br>`;
                
                if (data.checks) {
                    for (const [key, value] of Object.entries(data.checks)) {
                        document.getElementById('status').innerHTML += 
                            `${value ? '✅' : '❌'} ${key}: ${value}<br>`;
                    }
                }
            })
            .catch(error => {
                document.getElementById('status').innerHTML = 
                    `❌ Erro ao verificar sistema: ${error.message}`;
            });
    </script>
</body>
</html>
