<?php
// Create a file called test_db.php in your project root
require_once 'bootstrap.php';

echo "🔍 Testing database connection...\n";

try {
    // Test basic connection
    echo "✅ Database connected successfully!\n";
    
    // Check if table exists
    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_name = 'project_users'");
    $table = $stmt->fetch();
    
    if ($table) {
        echo "✅ Table 'project_users' exists!\n";
        
        // Check table structure
        $stmt = $pdo->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'project_users'");
        $columns = $stmt->fetchAll();
        
        echo "📋 Table structure:\n";
        foreach ($columns as $column) {
            echo "  - {$column['column_name']}: {$column['data_type']}\n";
        }
        
        // Check if there's any data
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM project_users");
        $count = $stmt->fetch();
        echo "📊 Number of users in table: {$count['count']}\n";
        
        // Show all data if any exist
        if ($count['count'] > 0) {
            echo "📋 Data in project_users table:\n";
            $stmt = $pdo->query("SELECT * FROM project_users");
            $records = $stmt->fetchAll();
            
            foreach ($records as $record) {
                echo "  - project_id: {$record['project_id']}, user_id: {$record['user_id']}\n";
            }
        } else {
            echo "⚠️  No records found in table!\n";
        }
        
        // Check if users table exists (where your actual user data should be)
        echo "\n🔍 Checking for 'users' table...\n";
        $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_name = 'users'");
        $usersTable = $stmt->fetch();
        
        if ($usersTable) {
            echo "✅ 'users' table found!\n";
            
            // Check users table structure
            $stmt = $pdo->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'users'");
            $userColumns = $stmt->fetchAll();
            
            echo "📋 Users table structure:\n";
            foreach ($userColumns as $column) {
                echo "  - {$column['column_name']}: {$column['data_type']}\n";
            }
            
            // Check users data
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $userCount = $stmt->fetch();
            echo "📊 Number of users: {$userCount['count']}\n";
            
            if ($userCount['count'] > 0) {
                echo "👥 Users in database:\n";
                $stmt = $pdo->query("SELECT * FROM users LIMIT 10");
                $users = $stmt->fetchAll();
                
                foreach ($users as $user) {
                    $userInfo = [];
                    foreach ($user as $key => $value) {
                        if (!is_numeric($key)) { // Skip numeric indices
                            $userInfo[] = "$key: $value";
                        }
                    }
                    echo "  - " . implode(', ', $userInfo) . "\n";
                }
            }
        } else {
            echo "❌ 'users' table not found!\n";
            echo "💡 Your user data should be in a 'users' table, not 'project_users'\n";
        }
        
    } else {
        echo "❌ Table 'project_users' does not exist!\n";
        echo "📝 You need to create the table first. Here's the SQL:\n\n";
        
        echo "CREATE TABLE project_users (\n";
        echo "    id SERIAL PRIMARY KEY,\n";
        echo "    username VARCHAR(50) UNIQUE NOT NULL,\n";
        echo "    first_name VARCHAR(50) NOT NULL,\n";
        echo "    last_name VARCHAR(50) NOT NULL,\n";
        echo "    password VARCHAR(255) NOT NULL,\n";
        echo "    role VARCHAR(20) DEFAULT 'user',\n";
        echo "    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n";
        echo ");\n\n";
        
        echo "-- Insert your seed data:\n";
        echo "INSERT INTO project_users (username, first_name, last_name, password, role) VALUES\n";
        echo "('john.smith', 'John', 'Smith', 'p@ssW0rd1234', 'designer'),\n";
        echo "('admin', 'Admin', 'User', 'password', 'admin'),\n";
        echo "('jm', 'jm', 'rivera', '12345', 'user');\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    echo "🔧 Check your database connection settings in .env file\n";
}
?>