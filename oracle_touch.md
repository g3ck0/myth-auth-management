# How to Track Tables Updated/Inserted by a Process or Package in Oracle

Below are methods to identify tables modified by a specific process or package in Oracle:

---

## 1. **Oracle Auditing**  
Enable auditing to track DML operations (INSERT, UPDATE, DELETE).  

**Steps**:  
1. Enable auditing (requires `AUDIT_ADMIN` role):  
   ```sql
   AUDIT INSERT TABLE, UPDATE TABLE, DELETE TABLE BY <schema_name> BY ACCESS;
   ```

2. Query audit logs:

   ```sql
    SELECT obj_name, action_name, timestamp
    FROM dba_audit_trail
    WHERE owner = '<schema_name>'
    AND action_name IN ('INSERT', 'UPDATE')
    AND timestamp >= SYSDATE - 1/24; 
   ```
##
## 2. Query Dependencies
Find tables referenced by a package/procedure:


   ```sql
    SELECT name, referenced_name
FROM dba_dependencies
WHERE owner = '<schema_name>'
  AND type IN ('PACKAGE', 'PACKAGE BODY', 'PROCEDURE')
  AND referenced_type = 'TABLE';
   ```

## 3. Use V$SQL to Track Recent SQL

Identify DML statements executed by the process:


   ```sql
    SELECT sql_text, executions, last_active_time
FROM v$sql
WHERE (sql_text LIKE '%INSERT%' OR sql_text LIKE '%UPDATE%')
  AND parsing_schema_name = '<schema_name>'
  AND last_active_time >= SYSDATE - 1/24; -- Last 1 hour
   ```

## 4. Flashback Query

Compare table states before/after execution (requires undo retention):

   ```sql
    -- Example: Check changes for a specific table
SELECT * FROM employees
AS OF TIMESTAMP (SYSTIMESTAMP - INTERVAL '1' HOUR)
MINUS
SELECT * FROM employees;
   ```

## 5. Logging Within the Package
Add custom logging to the package:

1. Create a logging table:

   ```sql
    CREATE TABLE dml_log (
      table_name VARCHAR2(30),
      dml_type VARCHAR2(10),
      timestamp DATE
    );
   ```

2. Add logging logic to the package:

   ```sql
    PROCEDURE update_employees IS
    BEGIN
      INSERT INTO dml_log VALUES ('EMPLOYEES', 'INSERT', SYSDATE);
      -- Your DML logic here
    END;
   ```

## 6. Fine-Grained Auditing (FGA)
Audit specific DML operations on a table:

   ```sql
    BEGIN
      DBMS_FGA.ADD_POLICY(
        object_schema   => '<schema_name>',
        object_name     => '<table_name>',
        policy_name     => 'AUDIT_DML',
        audit_condition => '1=1', -- Audit all rows
        audit_column    => NULL,
        handler_schema  => NULL,
        enable          => TRUE
      );
    END;
    /
   ```

## 7. Session Tracing
Capture SQL statements from a session:

1. Enable tracing:

   ```sql
    EXEC DBMS_MONITOR.SESSION_TRACE_ENABLE(session_id => <sid>, serial_num => <serial#>);
   ```

2. Run the process.

3. Check the trace file in the UDUMP directory.

## Summary

- Immediate Results: Use V$SQL or session tracing.

- Long-Term Auditing: Enable standard auditing or FGA.

- Dependency Checks: Query dba_dependencies.
