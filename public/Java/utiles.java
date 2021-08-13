/*     */ public class utiles
/*     */ {
/*     */   public String formateaPlaca(String sPlaca) {
/*  18 */     String resultado = sPlaca;
/*  19 */     if (condicionCadena(sPlaca)) {
/*  20 */       String stemporal = sPlaca.trim();
/*  21 */       if (stemporal.length() >= 3) {
/*  22 */         int l = stemporal.length();
/*  23 */         String sNuevo = "";
/*  24 */         for (int i = 0; i < l; i++) {
/*  25 */           if (!stemporal.substring(i, i + 1).equals("-") && !stemporal.substring(i, i + 1).equals(" "))
/*     */           {
/*     */ 
/*     */             
/*  29 */             sNuevo = sNuevo + stemporal.substring(i, i + 1);
/*     */           }
/*     */         } 
/*  32 */         resultado = sNuevo.toUpperCase();
/*     */       } 
/*     */     } 
/*  35 */     return resultado;
/*     */   }
/*     */   public boolean validaPlaca(String sPlaca) {
/*  38 */     boolean resultado = false;
/*  39 */     resultado = validaCadena(sPlaca, "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ");
/*  40 */     if (!resultado) {
/*  41 */       System.out.println("Err ValidaPlaca: " + sPlaca);
/*     */     }
/*     */     
/*  44 */     return resultado;
/*     */   }
/*     */   public boolean validaCadena(String sCadena, String base) {
/*  47 */     boolean b = true;
/*  48 */     if (condicionCadena(sCadena)) {
/*  49 */       long lSize = sCadena.length();
/*     */       
/*  51 */       for (int i = 0; i < lSize; i++) {
/*  52 */         String c = sCadena.substring(i, i + 1);
/*  53 */         int j = base.indexOf(c);
/*  54 */         if (j < 0) {
/*  55 */           System.out.println("Cadena Error: " + sCadena);
/*  56 */           b = false;
/*     */         } 
/*     */       } 
/*     */     } else {
/*  60 */       b = false;
/*  61 */     }  return b;
/*     */   }
/*     */   public String formateaCoordenada(String sCoordenada) {
/*  64 */     String resultado = "";
/*  65 */     if (condicionCadena(sCoordenada)) {
/*  66 */       String temporal = sCoordenada.trim();
/*  67 */       int ll = temporal.length();
/*  68 */       if (ll > 0) {
/*  69 */         for (int i = 0; i < ll; i++) {
/*  70 */           if (!temporal.substring(i, i + 1).equals(" "))
/*     */           {
/*     */ 
/*     */             
/*  74 */             resultado = resultado + temporal.substring(i, i + 1);
/*     */           }
/*     */         } 
/*     */       }
/*     */     } else {
/*     */       
/*  80 */       resultado = sCoordenada;
/*     */     } 
/*  82 */     return resultado;
/*     */   }
/*     */   
/*     */   public boolean validaCoordenada(String sCadena) {
/*  86 */     boolean b = false;
/*  87 */     if (condicionCadena(sCadena)) {
/*  88 */       String nuevo = sCadena.trim();
/*  89 */       boolean x = validaCadena(sCadena, "0123456789.-");
/*  90 */       if (x) {
/*  91 */         int contmenos = 0;
/*  92 */         int contpunto = 0;
/*  93 */         for (int i = 0; i < nuevo.length(); i++) {
/*  94 */           if (nuevo.substring(i, i + 1).equals("-")) {
/*  95 */             contmenos++;
/*     */           }
/*  97 */           if (nuevo.substring(i, i + 1).equals(".")) {
/*  98 */             contpunto++;
/*     */           }
/*     */         } 
/* 101 */         if (contmenos <= 1 && contpunto == 1) {
/* 102 */           if (contmenos == 1) {
/* 103 */             if (nuevo.indexOf("-") == 0) {
/* 104 */               b = true;
/*     */             }
/*     */           } else {
/* 107 */             b = true;
/*     */           } 
/*     */         }
/*     */       } 
/*     */     } 
/* 112 */     if (!b) {
/* 113 */       System.out.println("Err ValidaCoordenada: " + sCadena);
/*     */     }
/* 115 */     return b;
/*     */   }
/*     */   public boolean validaEvento(String sCadena) {
/* 118 */     boolean b = false;
/* 119 */     if (condicionCadena(sCadena)) {
/* 120 */       b = validaCadena(sCadena, "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ");
/*     */     }
/* 122 */     return b;
/*     */   }
/*     */   public boolean validaVelocidad(String sCadena) {
/* 125 */     boolean b = false;
/* 126 */     if (condicionCadena(sCadena)) {
/* 127 */       boolean x = validaCadena(sCadena, "0123456789.");
/* 128 */       if (x) {
/* 129 */         int cpunto = 0;
/* 130 */         for (int i = 0; i < sCadena.length(); i++) {
/* 131 */           if (sCadena.substring(i, i + 1).equals(".")) {
/* 132 */             cpunto++;
/*     */           }
/*     */         } 
/* 135 */         if (cpunto <= 1 && 
/* 136 */           Double.parseDouble(sCadena) >= 0.0D) {
/* 137 */           b = true;
/*     */         }
/*     */       } 
/*     */     } 
/*     */     
/* 142 */     if (!b) {
/* 143 */       System.out.println("Err ValidaVelocidad: " + sCadena);
/*     */     }
/* 145 */     return b;
/*     */   }
/*     */   public boolean validaRumbo(String sCadena) {
/* 148 */     boolean b = false;
/* 149 */     if (condicionCadena(sCadena) && 
/* 150 */       validaCadena(sCadena, "0123456789") && 
/* 151 */       Long.parseLong(sCadena) >= 0L && Long.parseLong(sCadena) <= 360L) {
/* 152 */       b = true;
/*     */     }
/*     */ 
/*     */     
/* 156 */     if (!b) {
/* 157 */       System.out.println("Err ValidaRumbo: " + sCadena);
/*     */     }
/* 159 */     return b;
/*     */   }
/*     */   public boolean condicionCadena(String sCadena) {
/* 162 */     boolean b = false;
/* 163 */     if (sCadena != null && 
/* 164 */       sCadena.trim().length() > 0) {
/* 165 */       b = true;
/*     */     }
/*     */     
/* 168 */     return b;
/*     */   }
/*     */   
/*     */   public boolean validaFechahora(String sCadena) {
/* 172 */     boolean b = false;
/* 173 */     if (condicionCadena(sCadena)) {
/* 174 */       boolean x = validaCadena(sCadena, "0123456789/ :");
/*     */       
/* 176 */       if (x) {
/* 177 */         String fecha = sCadena.substring(0, 10);
/*     */         
/* 179 */         String hora = sCadena.substring(11, 13);
/*     */         
/* 181 */         String minuto = sCadena.substring(14, 16);
/*     */         
/* 183 */         String segundo = sCadena.substring(17, 19);
/*     */         
/* 185 */         boolean y = validaHora(hora, minuto, segundo);
/* 186 */         boolean z = validaFecha(fecha);
/* 187 */         if (y && z) {
/* 188 */           b = true;
/*     */         }
/*     */       }
/*     */       else {
/*     */         
/* 193 */         System.out.println("Err ValidaFechaHora validaCadena: " + sCadena);
/*     */       } 
/* 195 */     }  if (!b) {
/* 196 */       System.out.println("Err ValidaFechaHora: " + sCadena);
/*     */     }
/* 198 */     return b;
/*     */   }
/*     */   private boolean validaHora(String h, String m, String s) {
/* 201 */     boolean b = false;
/* 202 */     if (Integer.parseInt(h) >= 0 && Integer.parseInt(h) < 24 && 
/* 203 */       Integer.parseInt(m) >= 0 && Integer.parseInt(m) < 60 && 
/* 204 */       Integer.parseInt(s) >= 0 && Integer.parseInt(s) < 60) {
/* 205 */       b = true;
/*     */     }
/*     */ 
/*     */     
/* 209 */     return b;
/*     */   }
/*     */   
/*     */   private static boolean isNumeric(String cadena) {
/*     */     try {
/* 214 */       Integer.parseInt(cadena);
/* 215 */       return true;
/* 216 */     } catch (NumberFormatException nfe) {
/* 217 */       return false;
/*     */     } 
/*     */   }
/*     */   
/*     */   private boolean validaFecha(String fecha) {
/* 222 */     boolean b = false;
/* 223 */     int tipo = 1;
/* 224 */     String d = fecha.substring(6, 10) + fecha.substring(3, 5) + fecha.substring(0, 2);
/* 225 */     if (!isNumeric(d)) {
/*     */       
/* 227 */       d = fecha.substring(0, 4) + fecha.substring(5, 7) + fecha.substring(8, 10);
/* 228 */       tipo = 2;
/*     */     } 
/*     */     
/* 231 */     if (Long.parseLong(d) >= 20120101L) {
/* 232 */       int dia = Integer.parseInt(d.substring(6, 8));
/* 233 */       int mes = Integer.parseInt(d.substring(4, 6));
/* 234 */       int anio = Integer.parseInt(d.substring(0, 4));
/* 235 */       if (mes > 0 && mes <= 12) {
/*     */         int maxdia;
/* 237 */         if (mes == 2) {
/* 238 */           if (anio % 4 == 0 && (anio % 100 != 0 || anio % 400 == 0)) {
/* 239 */             maxdia = 29;
/*     */           } else {
/*     */             
/* 242 */             maxdia = 28;
/*     */           } 
/*     */         }
/*     */         
/* 246 */         if (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12) {
/* 247 */           maxdia = 31;
/*     */         } else {
/*     */           
/* 250 */           maxdia = 30;
/*     */         } 
/* 252 */         if (dia > 0 && dia <= maxdia) {
/* 253 */           b = true;
/*     */         }
/*     */       } 
/*     */     } 
/* 257 */     return b;
/*     */   }
/*     */   public boolean validaTrama(String sPlaca, String sLatitud, String sLongitud, String sVelocidad, String sRumbo, String sFecha, String sEvento, String sFechaemv) {
/* 260 */     boolean b = false;
/* 261 */     if (validaPlaca(sPlaca)) {
/* 262 */       if (validaCoordenada(sLatitud) && validaCoordenada(sLongitud)) {
/* 263 */         if (validaVelocidad(sVelocidad)) {
/* 264 */           if (validaRumbo(sRumbo)) {
/* 265 */             if (validaFechahora(sFecha)) {
/* 266 */               if (validaEvento(sEvento)) {
/* 267 */                 if (validaFechahora(sFechaemv)) {
/* 268 */                   b = true;
/*     */                 } else {
/* 270 */                   System.out.println("Error de validación de Fecha registro " + sFechaemv);
/*     */                 } 
/*     */               } else {
/* 273 */                 System.out.println("Error de validación de Evento " + sEvento);
/*     */               } 
/*     */             } else {
/* 276 */               System.out.println("Error de validación de Fecha " + sFecha);
/*     */             } 
/*     */           } else {
/* 279 */             System.out.println("Error de validación de rumbo " + sRumbo);
/*     */           } 
/*     */         } else {
/* 282 */           System.out.println("Error de validación de velocidad " + sVelocidad);
/*     */         } 
/*     */       } else {
/*     */         
/* 286 */         System.out.println("Error de validación de coordenada " + sLatitud + " : " + sLongitud);
/*     */       } 
/*     */     } else {
/* 289 */       System.out.println("Error de validación de placa " + sPlaca);
/*     */     } 
/* 291 */     return b;
/*     */   }
/*     */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesm\\utiles.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */