
/*    */ import java.sql.Connection;
/*    */ import java.sql.Driver;
/*    */ import java.sql.DriverPropertyInfo;
/*    */ import java.sql.SQLException;
/*    */ import java.sql.SQLFeatureNotSupportedException;
/*    */ import java.util.Properties;
/*    */ import java.util.logging.Logger;
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ class DriverShim
/*    */   implements Driver
/*    */ {
/*    */   private Driver driver;
/*    */   
/*    */   DriverShim(Driver d) {
/* 72 */     this.driver = d;
/*    */   }
/*    */   public boolean acceptsURL(String u) throws SQLException {
/* 75 */     return this.driver.acceptsURL(u);
/*    */   }
/*    */   public Connection connect(String u, Properties p) throws SQLException {
/* 78 */     return this.driver.connect(u, p);
/*    */   }
/*    */   public int getMajorVersion() {
/* 81 */     return this.driver.getMajorVersion();
/*    */   }
/*    */   public int getMinorVersion() {
/* 84 */     return this.driver.getMinorVersion();
/*    */   }
/*    */   public DriverPropertyInfo[] getPropertyInfo(String u, Properties p) throws SQLException {
/* 87 */     return this.driver.getPropertyInfo(u, p);
/*    */   }
/*    */   public boolean jdbcCompliant() {
/* 90 */     return this.driver.jdbcCompliant();
/*    */   }
/*    */   
/*    */   public Logger getParentLogger() throws SQLFeatureNotSupportedException {
/* 94 */     throw new UnsupportedOperationException("Not supported yet.");
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\DriverShim.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */