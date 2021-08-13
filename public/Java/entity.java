/*     */ import java.io.File;
/*     */ import java.io.FileInputStream;
/*     */ import java.io.FileNotFoundException;
/*     */ import java.io.FileOutputStream;
/*     */ import java.io.IOException;
/*     */ import java.io.ObjectInputStream;
/*     */ import java.io.ObjectOutputStream;
/*     */ import java.util.logging.Level;
/*     */ import java.util.logging.Logger;
/*     */ public class entity
/*     */ {
/*     */   private String url;
/*     */   private String driver;
/*     */   private String usuario;
/*     */   private String clave;
/*     */   private String sql;
/*     */   private propiedades dato;
/*  35 */   private String archivo = "file.bin";
/*     */   private String ruta;
/*     */   
/*     */   public String getArchivo() {
/*  39 */     return this.archivo;
/*     */   }
/*     */   private String upd;
/*     */   public void setArchivo(String archivo) {
/*  43 */     this.archivo = archivo;
/*     */   }
/*     */   
/*     */   public propiedades getDato() {
/*  47 */     return this.dato;
/*     */   }
/*     */   
/*     */   public void setDato(propiedades dato) {
/*  51 */     this.dato = dato;
/*     */   }
/*     */   
/*     */   public String getUpd() {
/*  55 */     return denc(this.upd);
/*     */   }
/*     */   
/*     */   public void setUpd(String upd) {
/*  59 */     this.upd = enc(upd);
/*     */   }
/*     */   
/*     */   public String getRuta() {
/*  63 */     return denc(this.ruta);
/*     */   }
/*     */   
/*     */   public void setRuta(String ruta) {
/*  67 */     String a = enc(ruta);
/*  68 */     this.ruta = a;
/*     */   }
/*     */ 
/*     */   
/*     */   public String getClave() {
/*  73 */     return denc(this.clave);
/*     */   }
/*     */   
/*     */   public void setClave(String clave) {
/*  77 */     this.clave = enc(clave);
/*     */   }
/*     */   
/*     */   public String getDriver() {
/*  81 */     return denc(this.driver);
/*     */   }
/*     */   
/*     */   public void setDriver(String driver) {
/*  85 */     this.driver = enc(driver);
/*     */   }
/*     */   
/*     */   public String getSql() {
/*  89 */     return denc(this.sql);
/*     */   }
/*     */   
/*     */   public void setSql(String sql) {
/*  93 */     this.sql = enc(sql);
/*     */   }
/*     */   
/*     */   public String getUrl() {
/*  97 */     return denc(this.url);
/*     */   }
/*     */   
/*     */   public void setUrl(String url) {
/* 101 */     this.url = enc(url);
/*     */   }
/*     */   
/*     */   public String getUsuario() {
/* 105 */     return denc(this.usuario);
/*     */   }
/*     */   
/*     */   public void setUsuario(String usuario) {
/* 109 */     this.usuario = enc(usuario);
/*     */   }
/*     */   
/*     */   private String enc(String valor) {
/*     */     String cadena;
/*     */     try {
/* 115 */       cadena = seguridad.encrypt(valor);
/*     */     }
/* 117 */     catch (Exception ex) {
/* 118 */       cadena = null;
/*     */     } 
/* 120 */     return cadena;
/*     */   }
/*     */   
/*     */   private String denc(String valor) {
/*     */     String cadena;
/*     */     try {
/* 126 */       cadena = seguridad.decrypt(valor);
/*     */     }
/* 128 */     catch (Exception ex) {
/* 129 */       cadena = null;
/*     */     } 
/* 131 */     return cadena;
/*     */   }
/*     */   
/*     */   public Boolean enviar() {
/* 135 */     Boolean b = Boolean.valueOf(false);
/* 136 */     propiedades p = new propiedades();
/* 137 */     p.setDriver(this.driver);
/* 138 */     p.setClave(this.clave);
/* 139 */     p.setSql(this.sql);
/* 140 */     p.setUsuario(this.usuario);
/* 141 */     p.setUrl(this.url);
/* 142 */     p.setRuta(this.ruta);
/* 143 */     p.setUpd(this.upd);
/* 144 */     String archivo = this.archivo;
/*     */     try {
/* 146 */       FileOutputStream fos = new FileOutputStream(archivo);
/* 147 */       ObjectOutputStream out = new ObjectOutputStream(fos);
/* 148 */       out.writeObject(p);
/* 149 */       out.close();
/* 150 */       b = Boolean.valueOf(true);
/* 151 */     } catch (FileNotFoundException ex) {
/* 152 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/* 153 */     } catch (IOException ex) {
/* 154 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     } 
/* 156 */     return b;
/*     */   }
/*     */   
/*     */   public Boolean obtener() {
/* 160 */     Boolean b = Boolean.valueOf(false);
/*     */     try {
/* 162 */       File fichero = new File(this.archivo);
/* 163 */       if (fichero.exists()) {
/* 164 */         FileInputStream fis = new FileInputStream(this.archivo);
/* 165 */         ObjectInputStream ois = new ObjectInputStream(fis);
/*     */         
/* 167 */         if (ois != null) {
/* 168 */           propiedades p = (propiedades)ois.readObject();
/* 169 */           this.ruta = p.getRuta();
/* 170 */           this.clave = p.getClave();
/* 171 */           this.driver = p.getDriver();
/* 172 */           this.sql = p.getSql();
/* 173 */           this.usuario = p.getUsuario();
/* 174 */           this.url = p.getUrl();
/* 175 */           this.upd = p.getUpd();
/*     */         } 
/* 177 */         ois.close();
/* 178 */         b = Boolean.valueOf(true);
/*     */       } else {
/*     */         
/* 181 */         b = Boolean.valueOf(false);
/*     */       } 
/* 183 */     } catch (FileNotFoundException ex) {
/* 184 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     }
/* 186 */     catch (IOException ex) {
/* 187 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     }
/* 189 */     catch (ClassNotFoundException ex) {
/* 190 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     } 
/* 192 */     return b;
/*     */   }
/*     */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\entity.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */