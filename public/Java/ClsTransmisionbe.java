
/*     */ public class ClsTransmisionbe
/*     */ {
/*     */   private String sPlaca;
/*     */   private String sLatitud;
/*     */   private String sLongitud;
/*     */   private int iRumbo;
/*     */   private int iVelocidad;
/*     */   private String sFecha;
/*     */   private String sEmv;
/*     */   private String sEvento;
/*     */   private long lote;
/*     */   
/*     */   public ClsTransmisionbe() {}
/*     */   
/*     */   public ClsTransmisionbe(String sPlaca, String sLatitud, String sLongitud, int iRumbo, int iVelocidad, String sFecha, String sEmv, String sEvento, long lLote) {
/*  27 */     this.sPlaca = sPlaca;
/*  28 */     this.sLatitud = sLatitud;
/*  29 */     this.sLongitud = sLongitud;
/*  30 */     this.iRumbo = iRumbo;
/*  31 */     this.iVelocidad = iVelocidad;
/*  32 */     this.sFecha = sFecha;
/*  33 */     this.sEmv = sEmv;
/*  34 */     this.sEvento = sEvento;
/*  35 */     this.lote = lLote;
/*     */   }
/*     */   
/*     */   public long getLote() {
/*  39 */     return this.lote;
/*     */   }
/*     */   
/*     */   public void setLote(long lote) {
/*  43 */     this.lote = lote;
/*     */   }
/*     */   
/*     */   public String getsEvento() {
/*  47 */     return this.sEvento;
/*     */   }
/*     */   
/*     */   public void setsEvento(String sEvento) {
/*  51 */     this.sEvento = sEvento;
/*     */   }
/*     */   
/*     */   public String getsEmv() {
/*  55 */     return this.sEmv;
/*     */   }
/*     */   
/*     */   public void setsEmv(String sEmv) {
/*  59 */     this.sEmv = sEmv;
/*     */   }
/*     */   
/*     */   public int getiRumbo() {
/*  63 */     return this.iRumbo;
/*     */   }
/*     */   
/*     */   public void setiRumbo(int iRumbo) {
/*  67 */     this.iRumbo = iRumbo;
/*     */   }
/*     */   
/*     */   public int getiVelocidad() {
/*  71 */     return this.iVelocidad;
/*     */   }
/*     */   
/*     */   public void setiVelocidad(int iVelocidad) {
/*  75 */     this.iVelocidad = iVelocidad;
/*     */   }
/*     */   
/*     */   public String getsFecha() {
/*  79 */     return this.sFecha;
/*     */   }
/*     */   
/*     */   public void setsFecha(String sFecha) {
/*  83 */     this.sFecha = sFecha;
/*     */   }
/*     */   
/*     */   public String getsLatitud() {
/*  87 */     return this.sLatitud;
/*     */   }
/*     */   
/*     */   public void setsLatitud(String sLatitud) {
/*  91 */     this.sLatitud = sLatitud;
/*     */   }
/*     */   
/*     */   public String getsLongitud() {
/*  95 */     return this.sLongitud;
/*     */   }
/*     */   
/*     */   public void setsLongitud(String sLongitud) {
/*  99 */     this.sLongitud = sLongitud;
/*     */   }
/*     */   
/*     */   public String getsPlaca() {
/* 103 */     return this.sPlaca;
/*     */   }
/*     */   
/*     */   public void setsPlaca(String sPlaca) {
/* 107 */     this.sPlaca = sPlaca;
/*     */   }
/*     */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\ClsTransmisionbe.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */