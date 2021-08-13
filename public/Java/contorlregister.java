
/*     */ import java.io.File;
/*     */ import java.io.FileInputStream;
/*     */ import java.io.FileNotFoundException;
/*     */ import java.io.FileOutputStream;
/*     */ import java.io.IOException;
/*     */ import java.io.ObjectInputStream;
/*     */ import java.io.ObjectOutputStream;
/*     */ import java.util.logging.Level;
/*     */ import java.util.logging.Logger;
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ 
/*     */ public class contorlregister
/*     */ {
/*     */   private String a;
/*     */   private String b;
/*     */   private String archivo;
/*     */   
/*     */   public contorlregister() {
/*  28 */     this.archivo = "inicio.bin";
/*     */   }
/*     */   
/*     */   public contorlregister(String a, String b) {
/*  32 */     this.a = enc(a);
/*  33 */     this.b = enc(b);
/*     */   }
/*     */   
/*     */   public String getA() {
/*  37 */     return denc(this.a);
/*     */   }
/*     */   
/*     */   public void setA(String a) {
/*  41 */     this.a = enc(a);
/*     */   }
/*     */   
/*     */   public String getB() {
/*  45 */     return denc(this.b);
/*     */   }
/*     */   
/*     */   public void setB(String b) {
/*  49 */     this.b = enc(b);
/*     */   }
/*     */   
/*     */   private String enc(String valor) {
/*     */     String cadena;
/*     */     try {
/*  55 */       cadena = seguridad.encrypt(valor);
/*     */     }
/*  57 */     catch (Exception ex) {
/*  58 */       cadena = null;
/*     */     } 
/*  60 */     return cadena;
/*     */   }
/*     */   
/*     */   private String denc(String valor) {
/*     */     String cadena;
/*     */     try {
/*  66 */       cadena = seguridad.decrypt(valor);
/*     */     }
/*  68 */     catch (Exception ex) {
/*  69 */       cadena = null;
/*     */     } 
/*  71 */     return cadena;
/*     */   }
/*     */   
/*     */   public Boolean enviar() {
/*  75 */     Boolean b = Boolean.valueOf(false);
/*  76 */     register p = new register();
/*  77 */     p.setA(this.a);
/*  78 */     p.setB(this.b);
/*  79 */     String archivo = this.archivo;
/*     */     try {
/*  81 */       FileOutputStream fos = new FileOutputStream(archivo);
/*  82 */       ObjectOutputStream out = new ObjectOutputStream(fos);
/*  83 */       out.writeObject(p);
/*  84 */       out.close();
/*  85 */       b = Boolean.valueOf(true);
/*  86 */     } catch (FileNotFoundException ex) {
/*  87 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*  88 */     } catch (IOException ex) {
/*  89 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     } 
/*  91 */     return b;
/*     */   }
/*     */   
/*     */   public Boolean obtener() {
/*  95 */     Boolean b = Boolean.valueOf(false);
/*     */     try {
/*  97 */       File fichero = new File(this.archivo);
/*  98 */       if (fichero.exists()) {
/*  99 */         FileInputStream fis = new FileInputStream(this.archivo);
/* 100 */         ObjectInputStream ois = new ObjectInputStream(fis);
/*     */         
/* 102 */         if (ois != null) {
/* 103 */           register p = (register)ois.readObject();
/* 104 */           this.a = p.getA();
/* 105 */           this.b = p.getB();
/*     */         } 
/* 107 */         ois.close();
/* 108 */         b = Boolean.valueOf(true);
/*     */       } else {
/*     */         
/* 111 */         b = Boolean.valueOf(false);
/*     */       } 
/* 113 */     } catch (FileNotFoundException ex) {
/* 114 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     }
/* 116 */     catch (IOException ex) {
/* 117 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     }
/* 119 */     catch (ClassNotFoundException ex) {
/* 120 */       Logger.getLogger(entity.class.getName()).log(Level.SEVERE, (String)null, ex);
/*     */     } 
/* 122 */     return b;
/*     */   }
/*     */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\contorlregister.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */