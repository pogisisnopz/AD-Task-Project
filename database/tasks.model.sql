CREATE TABLE IF NOT EXISTS tasks (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    task_name varchar(255) NOT NULL,
    description text,
    status varchar(50),
    due_date date,
    project_id uuid REFERENCES projects (id),
    assigned_to uuid REFERENCES users (id)
);