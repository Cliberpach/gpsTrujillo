/*    */ 
/*    */ import java.io.Serializable;
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
/*    */ public class propiedades
/*    */   implements Serializable
/*    */ {
/*    */   private String url;
/*    */   private String driver;
/*    */   private String usuario;
/*    */   private String clave;
/*    */   private String sql;
/*    */   private String ruta;
/*    */   private String upd;
/*    */   
/*    */   public String getUpd() {
/* 27 */     return this.upd;
/*    */   }
/*    */   
/*    */   public void setUpd(String upd) {
/* 31 */     this.upd = upd;
/*    */   }
/*    */   
/*    */   public String getRuta() {
/* 35 */     return this.ruta;
/*    */   }
/*    */   
/*    */   public void setRuta(String ruta) {
/* 39 */     this.ruta = ruta;
/*    */   }
/*    */   
/*    */   public String getClave() {
/* 43 */     return this.clave;
/*    */   }
/*    */   
/*    */   public void setClave(String clave) {
/* 47 */     this.clave = clave;
/*    */   }
/*    */   
/*    */   public String getDriver() {
/* 51 */     return this.driver;
/*    */   }
/*    */   
/*    */   public void setDriver(String driver) {
/* 55 */     this.driver = driver;
/*    */   }
/*    */   
/*    */   public String getSql() {
/* 59 */     return this.sql;
/*    */   }
/*    */   
/*    */   public void setSql(String sql) {
/* 63 */     this.sql = sql;
/*    */   }
/*    */   
/*    */   public String getUrl() {
/* 67 */     return this.url;
/*    */   }
/*    */   
/*    */   public void setUrl(String url) {
/* 71 */     this.url = url;
/*    */   }
/*    */   
/*    */   public String getUsuario() {
/* 75 */     return this.usuario;
/*    */   }
/*    */   
/*    */   public void setUsuario(String usuario) {
/* 79 */     this.usuario = usuario;
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\propiedades.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */