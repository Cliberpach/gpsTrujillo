import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.net.Socket;
import java.sql.Connection;
import java.sql.Date;
import java.sql.ResultSet;
import java.sql.Statement;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

/**
 *
 * @author Pablo
 */
public class Main {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        System.out.println("Inicio");
        Conectar cn=new Conectar();
        Connection cBd=cn.conectar();
        String sUsuario, sClave;
        Socket s = null;
        conexion cSocket = null;
        sUsuario="20603858957";
        sClave="sutran2016";
        cSocket = conexion.getConecion();
        s = cSocket.getConnection();
        try
        {
                    DataInputStream in = new DataInputStream(s.getInputStream());
                    DataOutputStream out = new DataOutputStream(s.getOutputStream()); 
                    String cClaro = "identificacion|" + sUsuario + "|" + sClave;
                    String cadena = seguridad.encrypt(cClaro);
                    out.writeUTF(cadena);
                    String data = in.readUTF();
                    long ll = Long.parseLong(data);
                    out.close();
                    in.close();
                    s.close();
                    out = null;
                    in = null;
                    s = null;
                    cSocket = null;
                    Listener listener = new Listener(cBd,ll);
                    listener.start();
                    
        }
        catch(Exception e)
        {
            System.out.println(e.toString());
        }
       
       
    }

    
}
    class Listener extends Thread{
        private Connection cBd;
        private String ll;
        Listener(Connection conn,long ll) throws Exception {
            this.cBd = conn;
            this.ll=String.valueOf(ll);
        }

        public void run(){
            while(true)
                {
                    try{
                    String sql="select * from sutran where estado='0'";
                    Statement statement = this.cBd.createStatement();
                    ResultSet result = statement.executeQuery(sql);
                   if(result.getRow()==0)
                    {
                    List<Dispositivo> dispositivos = new ArrayList<Dispositivo>();
                    String sqldispositivos="select * from dispositivo where sutran='SI' ";
                    Statement st=this.cBd.createStatement();
                    ResultSet rs=st.executeQuery(sqldispositivos);
                    //------------------------------------
                                    Socket s = null;
                                    conexion cSocket = null;
                                    cSocket = conexion.getConecion();
                                    s = cSocket.getConnection();
                                    DataInputStream in = new DataInputStream(s.getInputStream());
                                    DataOutputStream out = new DataOutputStream(s.getOutputStream());
                                    String sLote = "lote|" + this.ll + "|" + "select * from sutran where estado='0'";
                      
                                    String cadenaLote = seguridad.encrypt(sLote);
                                    out.writeUTF(cadenaLote);
                                    String data = in.readUTF();
                     
                                    long lote = Long.parseLong(data);
                                    out.close();
                                    in.close();
                                    s.close();
                                    out = null;
                                    in = null;
                                    s = null;
                                    cSocket = null;

                    //------------------------------------
                    String cTrama = "trama|" + lote + "|";
                        while(rs.next())
                        {
                              Dispositivo d=new Dispositivo();
                              d.setImei(rs.getString("imei"));
                              d.setPlaca(rs.getString("placa"));
                              dispositivos.add(d);
                        }
                        rs.close();
                        st.close();
                        List<List<DispositivoGps>> ListDispositivo=new ArrayList<List<DispositivoGps>>();
                        List<DispositivoGps> dgps=new ArrayList<DispositivoGps>();
                        while(result.next())
                        {
                                    DispositivoGps dt=new DispositivoGps();
                                    dt.id=result.getString("id");
                                    dt.placa=result.getString("placa");
                                    dt.lat=result.getString("latitud");
                                    dt.lng=result.getString("longitud");
                                    dt.velocidad=result.getString("velocidad");
                                    if(Float.parseFloat(dt.velocidad)>2){
                                        dt.evento="ER";
                                     }
                                     else if (Float.parseFloat(dt.velocidad)>80)
                                     {
                                         dt.evento="EX";
                                     }
                                     else{
                                        dt.evento="PA";
                                    }
                                    String fr=result.getString("fecha");
//                                  //2021-07-22 14:43:32
                                    DateFormat format = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss", Locale.ENGLISH);
                                    java.util.Date datee = format.parse(fr);
                                    DateFormat df = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
                                    dt.fecha=df.format(datee);
                                    dgps.add(dt);
                        }
                        for(Dispositivo d:dispositivos)
                        {
                           List<DispositivoGps> dg=new ArrayList<DispositivoGps>();
                           for(DispositivoGps r:dgps)
                            {
                            
                               if(d.getPlaca().equals(r.placa))
                                {   
                                    dg.add(r);
                                }
                            }
                           ListDispositivo.add(dg);
                        } 
                            utiles u = new utiles();
                            List<DispositivoGps> dupdate=new ArrayList<DispositivoGps>();
                            for(int i=0;i<ListDispositivo.size();i++){
                                for(int j=0;j<ListDispositivo.get(i).size();j++)
                                    {
                                        if((j+1)<ListDispositivo.get(i).size())
                                            {
                                                Heading h=new Heading();
                                                double lati=Double.parseDouble(ListDispositivo.get(i).get(j).lat);
                                                double lngi=Double.parseDouble(ListDispositivo.get(i).get(j).lng);
                                                double latf=Double.parseDouble(ListDispositivo.get(i).get(j+1).lat);
                                                double lngf=Double.parseDouble(ListDispositivo.get(i).get(j+1).lng);
                                                double r=h.computeHeading(lati,lngi,latf,lngf);
                                                if(r<0)
                                                {   
                                                    r=(r*-1)+180;
                                                }
                                                ListDispositivo.get(i).get(j).rumbo=String.valueOf((int) r) ;
                                                String id=ListDispositivo.get(i).get(j).id;
                                                String placa= ListDispositivo.get(i).get(j).placa.replace("-", "");;
                                                String latitud=ListDispositivo.get(i).get(j).lat;
                                                String longitud=ListDispositivo.get(i).get(j).lng;
                                                String rumbo=ListDispositivo.get(i).get(j).rumbo;
                                                String velocidad=ListDispositivo.get(i).get(j).velocidad;
                                                String evento=ListDispositivo.get(i).get(j).evento;
                                                String fecha=ListDispositivo.get(i).get(j).fecha;
                                                String fechaemv=ListDispositivo.get(i).get(j).fecha;
                                                String respuesta;
                                                dupdate.add(ListDispositivo.get(i).get(j));
                                               boolean vt=u.validaTrama(placa, latitud, longitud, velocidad, rumbo, fecha, evento, fechaemv);
                                                    if(vt)
                                                    {
                                                      respuesta="1";
                                                    }else{
                                                      respuesta="0";
                                                    }
                                                String lineaTrama = placa + "#" + latitud + "#" + longitud + "#" + rumbo + "#" + velocidad +"#" + evento + "#" + fecha + "#" + ll + "#" + fechaemv + "#" + id+ "#" + respuesta + "&";
                                                cTrama = cTrama + lineaTrama;
                                            }
                                    }
                            }
                            for(DispositivoGps e:dupdate)
                            {
                                 Statement sr = this.cBd.createStatement();
                                 String sqlw="update sutran set rumbo='"+e.rumbo+"',evento='"+e.evento+"',estado='1' where id='"+e.id+"';";
                                 sr.executeUpdate(sqlw);
                                 sr.close();
                            }
                           
                            if(dupdate.size()!=0){
                                    String retp="e";
                                    Socket s1 = null;
                                    conexion cSocket1 = null;
                                    cSocket1 = conexion.getConecion();
                                    s1 = cSocket1.getConnection();

                                DataInputStream in1 = new DataInputStream(s1.getInputStream());
                                DataOutputStream out1 = new DataOutputStream(s1.getOutputStream());
                                String cadenaTrama = seguridad.encrypt(cTrama);
                                    out1.writeUTF(cadenaTrama);
                                    Thread.sleep(3000);
                                     retp = in1.readUTF();
                                    Thread.sleep(3000);
                                    out1.close();
                                    in1.close();
                                    s1.close();
                                    out1 = null;
                                    in1 = null;
                                    s1 = null;
                                    cSocket1 = null;
                                    for(DispositivoGps e:dupdate)
                                    {
                                         Statement sr1 = this.cBd.createStatement();
                                         String sqlw1="update sutran set respuesta='"+retp+"' where id='"+e.id+"';";
                                         sr1.executeUpdate(sqlw1);
                                         sr1.close();
                                    }
                          //out.writeUTF(cadenaTrama);

                          //data = in.readUTF();
                            }
                            
                             
                            
                         }
                        result.close();
                        statement.close();
                      
        
                        Thread.sleep(5000);
                    }
                    catch(Exception e)
                    {
                         System.out.println(e);
                    }
                }
        
        }
    }