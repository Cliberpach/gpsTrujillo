
/*    */ 
/*    */ import java.io.IOException;
/*    */ import java.net.Socket;
/*    */ import java.net.URL;
/*    */ import java.net.UnknownHostException;
/*    */ import java.util.logging.Level;
/*    */ import java.util.logging.Logger;
/*    */ import javax.net.ssl.HttpsURLConnection;
/*    */ 
/*    */ public class conexion
/*    */ {
/* 27 */   private String dominio = "sig.sutran.gob.pe";
/* 28 */   private String ip = "181.177.244.104";
/* 29 */   private int puerto = 5889;
/*    */ 
/*    */ 
/*    */   
/*    */   private static conexion instance;
/*    */ 
/*    */ 
/*    */ 
/*    */   
/*    */   public static conexion getConecion() {
/* 39 */     if (instance == null)
/*    */     {
/* 41 */       instance = new conexion();
/*    */     }
/*    */     
/* 44 */     return instance;
/*    */   }
/*    */ 
/*    */   
/*    */   public Socket getConnection() {
/* 49 */     Socket s = null;
/*    */     try {
/* 51 */       if (getConnectionStatus().booleanValue()) {
/* 52 */         s = new Socket(this.dominio, this.puerto);
/*    */       } else {
/* 54 */         System.out.println("No tiene conexión con internet ...");
/*    */       } 
/* 56 */     } catch (UnknownHostException ex) {
/*    */       
/*    */       try {
/* 59 */         s = new Socket(this.ip, this.puerto);
/* 60 */       } catch (UnknownHostException ex1) {
/* 61 */         Logger.getLogger(conexion.class.getName()).log(Level.SEVERE, (String)null, ex1);
/* 62 */       } catch (IOException ex1) {
/* 63 */         Logger.getLogger(conexion.class.getName()).log(Level.SEVERE, (String)null, ex1);
/*    */       } 
/* 65 */     } catch (IOException ex) {
/*    */       
/* 67 */       s = null;
/*    */     } 
/* 69 */     return s;
/*    */   }
/*    */   
/*    */   public Boolean getConnectionStatus() {
/* 73 */     Boolean b = Boolean.valueOf(false);
/* 74 */     URL u = null;
/*    */     
/*    */     try {
/* 77 */       u = new URL("https://www.google.com.pe/");
/* 78 */       HttpsURLConnection huc = (HttpsURLConnection)u.openConnection();
/* 79 */       huc.connect();
/* 80 */       b = Boolean.valueOf(true);
/* 81 */       u = null;
/* 82 */       huc.disconnect();
/* 83 */     } catch (Exception e) {
/* 84 */       b = Boolean.valueOf(false);
/* 85 */       u = null;
/* 86 */       HttpsURLConnection huc = null;
/*    */     } 
/* 88 */     u = null;
/* 89 */     Object object = null;
/* 90 */     return b;
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\conexion.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */