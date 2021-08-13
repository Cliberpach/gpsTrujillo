
/*    */ 
/*    */ import java.io.File;
/*    */ import java.net.URL;
/*    */ import java.net.URLClassLoader;
/*    */ import java.sql.Connection;
/*    */ import java.sql.Driver;
/*    */ import java.sql.DriverManager;
/*    */ public class cnx
/*    */ {
/*    */   private static cnx instance;
/*    */   private URLClassLoader ucl;
/*    */   
/*    */   public static cnx getCnx() {
/* 36 */     if (instance == null)
/*    */     {
/* 38 */       instance = new cnx();
/*    */     }
/*    */     
/* 41 */     return instance;
/*    */   }
/*    */ 
/*    */   
/*    */   public Connection getConnection(propiedades p) {
/* 46 */     Connection c = null;
/*    */     try {
/* 48 */       File f = new File(p.getRuta());
/*    */       
/* 50 */       if (f.exists()) {
/* 51 */         URL a = f.toURL();
/* 52 */         URL u = new URL("jar:file:" + a.getPath() + "!/");
/* 53 */         String classname = p.getDriver();
/* 54 */         URLClassLoader ucl = new URLClassLoader(new URL[] { u });
/* 55 */         Driver d = (Driver)Class.forName(classname, true, ucl).newInstance();
/* 56 */         DriverManager.registerDriver(new DriverShim(d));
/* 57 */         c = DriverManager.getConnection(p.getUrl(), p.getUsuario(), p.getClave().trim());
/* 58 */         String str1 = "";
/*    */       }
/*    */     
/* 61 */     } catch (Exception ex) {
/* 62 */       String str = ex.toString();
/*    */     } 
/* 64 */     return c;
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\cnx.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */