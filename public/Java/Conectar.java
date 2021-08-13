import java.sql.*;
class Conectar {
     Connection con=null;
    public Connection conectar(){
        try{
           Class.forName("com.mysql.cj.jdbc.Driver");
            con = DriverManager.getConnection("jdbc:mysql://localhost:3306/gpstracker","usuario","gps12345678");
     
        }catch(ClassNotFoundException | SQLException e){
              System.out.println(e.toString());
        }
        return con;
    }
}