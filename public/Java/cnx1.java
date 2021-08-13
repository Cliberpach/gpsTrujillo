
/*    */ import java.io.File;
/*    */ import java.net.URL;
/*    */ import java.net.URLClassLoader;
/*    */ import java.sql.Connection;
/*    */ import java.sql.DriverManager;
/*    */ import java.util.logging.Level;
/*    */ import java.util.logging.Logger;

/*    */ public class cnx1
/*    */ {
/*    */   public Connection getConnection(propiedades p) {
/* 29 */     Connection c = null;
/*    */ 
/*    */     
/*    */     try {
/* 33 */       File f = new File(p.getRuta());
/*    */       
/* 35 */       if (f.exists()) {
/* 36 */         URL a = f.toURL();
/* 37 */         ClassLoader loader = URLClassLoader.newInstance(new URL[] { a }, getClass().getClassLoader());
/* 38 */         Class.forName(p.getDriver(), true, loader);
/* 39 */         c = DriverManager.getConnection(p.getUrl(), p.getUsuario(), p.getClave());
/*    */       } 
/*    */       
/* 42 */       String str = "aaa";
/*    */     }
/* 44 */     catch (Exception ex) {
/* 45 */       Logger.getLogger(cnx1.class.getName()).log(Level.SEVERE, (String)null, ex);
/*    */     } 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */     
/* 56 */     return c;
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\cnx1.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */