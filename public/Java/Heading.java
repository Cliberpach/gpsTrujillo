/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 *
 * @author Pablo
 */
public class Heading {
    public double computeHeading(double latinicial,double lnginicial,double latfinal,double lngfinal){
        double fromLat=Math.toRadians(latinicial);
        double fromLng=Math.toRadians(lnginicial);
        double toLat=Math.toRadians(latfinal);
        double toLng=Math.toRadians(lngfinal);
        double dLng=toLng-fromLng;
        double heading=Math.atan2(Math.sin(dLng)*Math.cos(toLat), Math.cos(fromLat) * Math.sin(toLat)
                - Math.sin(fromLat) * Math.cos(toLat) * Math.cos(dLng));
        return wrap(Math.toDegrees(heading),-180,180);
    }
    public double wrap(double n,double min,double max)
    {
        return (n >= min && n < max) ? n : (mod(n - min, max - min) + min); 
    }
    public double mod(double x,double m){
        return ((x % m) + m) % m;
    }
}
