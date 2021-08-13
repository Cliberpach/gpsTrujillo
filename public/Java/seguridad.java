/*    */ import java.io.File;
/*    */ import java.io.FileInputStream;
/*    */ import java.io.FileOutputStream;
/*    */ import java.io.IOException;
/*    */ import java.security.NoSuchAlgorithmException;
         import  java.util.Base64;
/*    */ import javax.crypto.Cipher;
/*    */ import javax.crypto.KeyGenerator;
/*    */ import javax.crypto.SecretKey;
/*    */ import javax.crypto.spec.SecretKeySpec;
///*    */ import sun.misc.BASE64Decoder;
///*    */ import sun.misc.BASE64Encoder;

/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ 
/*    */ public class seguridad
/*    */ {
/*    */   private static SecretKeySpec getKeySpec() throws IOException, NoSuchAlgorithmException {
/* 26 */     byte[] bytes = new byte[16];
/* 27 */     File f = new File("/var/www/gpsbpmsac/public/Java/key/file");
/*    */     
/* 29 */     SecretKey key = null;
/* 30 */     SecretKeySpec spec = null;
/* 31 */     if (f.exists()) {
/* 32 */       (new FileInputStream(f)).read(bytes);
/*    */     } else {
/*    */       
/* 35 */       System.out.println("genera");
/* 36 */       KeyGenerator kgen = KeyGenerator.getInstance("AES");
/* 37 */       kgen.init(256);
/* 38 */       key = kgen.generateKey();
/* 39 */       bytes = key.getEncoded();
/* 40 */       (new FileOutputStream(f)).write(bytes);
/*    */     } 
/* 42 */     spec = new SecretKeySpec(bytes, "AES");
/* 43 */     return spec;
/*    */   }
/*    */   
/*    */   public static String encrypt(String text) throws Exception {
/* 47 */     SecretKeySpec spec = getKeySpec();
/* 48 */     Cipher cipher = Cipher.getInstance("AES");
/* 49 */     cipher.init(1, spec);
/* 50 */    
            
/* 51 */     return Base64.getEncoder().encodeToString(cipher.doFinal(text.getBytes()));
        //enc.encode(cipher.doFinal(text.getBytes()));
/*    */   }
/*    */   public static String decrypt(String text) throws Exception {
/* 54 */     SecretKeySpec spec = getKeySpec();
/* 55 */     Cipher cipher = Cipher.getInstance("AES");
/* 56 */     cipher.init(2, spec);
/* 57 */     //BASE64Decoder dec = new BASE64Decoder();
/* 58 */     //return new String(cipher.doFinal(dec.decodeBuffer(text)));
                return new String(cipher.doFinal(Base64.getDecoder().decode(text)));
/*    */   }
/*    */ }


/* Location:              C:\Users\Pablo\Documents\Sutran\clienteConsola v2.1\clienteConsola.jar!\agentesmv\seguridad.class
 * Java compiler version: 5 (49.0)
 * JD-Core Version:       1.1.3
 */