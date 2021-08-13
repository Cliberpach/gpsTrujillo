
/*    */ public class configuracion
/*    */ {
/*    */   public int registrar(String sDriver, String sMclass, String sUrl, String sUsuariobd, String sClavebd, String sSql, String sUpdate) {
/* 17 */     int reg = 0;
/* 18 */     entity p = new entity();
/* 19 */     p.setDriver(sMclass);
/* 20 */     p.setUrl(sUrl);
/* 21 */     p.setUsuario(sUsuariobd);
/* 22 */     p.setClave(sClavebd);
/* 23 */     p.setRuta(sDriver);
/* 24 */     p.setSql(sSql);
/* 25 */     p.setUpd(sUpdate);
/* 26 */     Boolean bs = p.enviar();
/* 27 */     if (bs.booleanValue()) {
/* 28 */       System.out.println("Configuracion exitosa");
/* 29 */       reg = 1;
/*    */     } else {
/*    */       
/* 32 */       System.out.println("Configuracion exitosa");
/*    */     } 
/* 34 */     return reg;
/*    */   }
/*    */   public int automatico(String a, String b) {
/* 37 */     int i = 0;
/* 38 */     return i;
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\configuracion.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */