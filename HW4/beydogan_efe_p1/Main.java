
import java.sql.*;

/**
 * CS 353 Programming Assignment Part 1
 * Efe Beydogan
 * 21901548
 **/

public class Main {
	private static final String DB_NAME = "efe_beydogan";
	private static final String DB_USERNAME = "efe.beydogan";
	private static final String PASSWORD = "dCMFpIeU";
	private static final String URL = "jdbc:mysql://efe.beydogan@dijkstra.ug.bcc.bilkent.edu.tr/" +
            DB_NAME + "?user=" + DB_USERNAME + "&password=" + PASSWORD;
			
	public static void main( String[] args) {
	      
	      try
	      {
	         Class.forName("com.mysql.cj.jdbc.Driver");
	      }
	      catch( ClassNotFoundException e)
	      {
	         System.out.println("JBDC Driver cannot be located");
	      }
	      
	      
	      Connection con = null;
	      Statement stmt = null;
	      
	      // Connecting to the database
	      try
	      {
	        con =  DriverManager.getConnection(URL);
	        if ( con != null)
	        {
	           System.out.println("Successfully connected to the database.");
	        }
	        else
	        {
	           System.out.println("Error connecting to the database.");
	        }
	      }
	      catch(SQLException e)
	      {
	         System.out.println("Error connecting to the database.");
	      }
	      
	      
	      // SQL Queries
	      try
	      {
	         stmt = con.createStatement();
	         // table names
	         final String customer = "customer";
	         final String account = "account";
	         final String owns = "owns";
	         // drop tables
	         String sql = "DROP TABLE IF EXISTS " + owns;
	         stmt.executeUpdate(sql);
	         System.out.println(owns + " table is deleted");
	         
	         sql = "DROP TABLE IF EXISTS " + customer;
	         stmt.executeUpdate(sql);
	         System.out.println(customer + " table is deleted");
	         
	         sql = "DROP TABLE IF EXISTS " + account;
	         stmt.executeUpdate(sql);
	         System.out.println(account + " table is deleted");
	         
	         // create tables
	         sql = "CREATE TABLE customer " 
	            + "(cid CHAR(5), " 
	            + " name VARCHAR(30), " 
	            + " bdate DATE, "
	            + " address VARCHAR(30), "
	            + " city VARCHAR(20), "
	            + " nationality VARCHAR(20), "
	            + " PRIMARY KEY ( cid))"
	         	+ " ENGINE=InnoDB;";
	         
	         stmt.executeUpdate(sql);
	         System.out.println(customer + " table is created");
	         
	         sql = "CREATE TABLE account "
	 	            + "(aid CHAR(8), "
	 	            + " branch VARCHAR(20), "
	 	            + " balance FLOAT, "
	 	            + " openDate DATE, "
	 	            + " PRIMARY KEY ( aid))"
	 	            + " ENGINE=InnoDB;";
	 	         
	 	     stmt.executeUpdate(sql);
	 	     System.out.println(account + " table is created");
	         
	         sql = "CREATE TABLE owns "
	            + "(cid CHAR(5), "
	            + " aid CHAR(8), "
	            + " PRIMARY KEY ( cid, aid), " 
	            + " FOREIGN KEY (cid) REFERENCES customer(cid), "
	            + " FOREIGN KEY (aid) REFERENCES account(aid)) "
	            + " ENGINE=InnoDB;";
	         
	         stmt.executeUpdate(sql);
	         System.out.println(owns + " table is created");
	         
	         // insert into customer table
	         stmt.executeUpdate(
	        		 "INSERT INTO customer values('10001', 'Ayse', '1990-09-08', 'Bilkent', 'Ankara', 'TC');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO customer values('10002', 'Ali', '1985-10-16', 'Sariyer', 'Istanbul ', 'TC');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO customer values('10003', 'Ahmet', '1997-02-15', 'Karsiyaka', 'Izmir', 'TC');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO customer values('10004', 'John', '2003-04-26', 'Stretford', 'Manchester', 'UK');"
	         );

	         // insert into account table
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000001', 'Kizilay', '5000.00', '2019-11-01');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000002', 'Bilkent', '228000.00', '2011-01-05');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000003', 'Cankaya', '432000.00', '2012-05-14');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000004', 'Sincan', '10500.00', '2012-06-01');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000005', 'Tandogan', '77800.00', '2013-03-20');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000006', 'Eryaman', '25000.00', '2022-01-22');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO account values('A0000007', 'Umitkoy', '6000.00', '2017-04-21');"
	         );
	         
	         // insert into owns table
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10001', 'A0000001');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10001', 'A0000002');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10001', 'A0000003');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10001', 'A0000004');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10002', 'A0000002');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10002', 'A0000003');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10002', 'A0000005');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10003', 'A0000006');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10003', 'A0000007');"
	         );
	         stmt.executeUpdate(
	        		 "INSERT INTO owns values('10004', 'A0000006');"
	         );
	         
	         // print the results of queries
	         
	         // Give the name, birth date, and city of the youngest customer.
	         System.out.println( "Give the name, birth date, and city of the youngest customer.");
	         ResultSet rs = stmt.executeQuery("SELECT name, bdate, city FROM customer C where C.bdate = "
	         		+ "(SELECT max(bdate) FROM customer);");
	         
	         try {
	        	 while( rs.next()) {
	        		 System.out.print("Name: " + rs.getString("name") + ", ");
	        		 System.out.print("Birth Date: " + rs.getString("bdate") + ", ");
	        		 System.out.print("City: " + rs.getString("city"));
	        		 System.out.println();
	        	 }
	         } 
	         catch ( SQLException e) {
	        	 System.out.println( "SQL Exception: " + e.getMessage());
	         }
	         
	         // Give the names of the customers who have an account with a balance less than 50,000 TL.
	         System.out.println( "Give the names of the customers who have an account with a balance less than 50,000 TL.");
	         rs = stmt.executeQuery("SELECT distinct name FROM customer natural join owns natural join account WHERE balance < 50000;");
	         
	         try {
	        	 while( rs.next()) {
	        		 System.out.print("Name: " + rs.getString("name"));
	        		 System.out.println();
	        	 }
	         } 
	         catch ( SQLException e) {
	        	 System.out.println( "SQL Exception: " + e.getMessage());
	         }
	         
	         // Give the id and branch of the accounts which are owned by at least 2 customers.
	         System.out.println( "Give the id and branch of the accounts which are owned by at least 2 customers.");
	         rs = stmt.executeQuery("SELECT distinct aid, branch FROM account WHERE aid in (SELECT aid FROM owns GROUP BY aid HAVING count(*) >= 2);");
	         
	         try {
	        	 while( rs.next()) {
	        		 System.out.print("Account ID: " + rs.getString("aid") + ", ");
	        		 System.out.print("Account Branch: " + rs.getString("branch"));
	        		 System.out.println();
	        	 }
	         } 
	         catch ( SQLException e) {
	        	 System.out.println( "SQL Exception: " + e.getMessage());
	         }
	         
	         // Give the id and balance of the accounts which are owned by the oldest customer.
	         System.out.println( "Give the id and balance of the accounts which are owned by the oldest customer.");
	         rs = stmt.executeQuery("SELECT aid, balance FROM customer natural join account natural join owns WHERE bdate = (SELECT min(bdate) FROM customer);");
	         
	         try {
	        	 while( rs.next()) {
	        		 System.out.print("Account ID: " + rs.getString("aid") + ", ");
	        		 System.out.print("Account Balance: " + rs.getString("balance"));
	        		 System.out.println();
	        	 }
	         } 
	         catch ( SQLException e) {
	        	 System.out.println( "SQL Exception: " + e.getMessage());
	         }
	         
	         // Give the id of the customer who has the accounts with the highest total balance.
	         System.out.println( "Give the id of the customer who has the accounts with the highest total balance.");
	         rs = stmt.executeQuery("WITH balances(cid, balance_sum) as (SELECT cid, sum(balance) FROM account natural join owns GROUP BY cid) "
	         		+ "SELECT cid FROM customer WHERE cid in (SELECT cid FROM balances T WHERE T.balance_sum >= all (SELECT balance_sum FROM balances));");
	         
	         try {
	        	 while( rs.next()) {
	        		 System.out.print("Customer ID: " + rs.getString("cid"));
	        		 System.out.println();
	        	 }
	         } 
	         catch ( SQLException e) {
	        	 System.out.println( "SQL Exception: " + e.getMessage());
	         }
	      }
	      catch ( SQLException e)
	      {
	         System.out.println( "SQL Exception: " + e.getMessage());
	      }
	}
}
