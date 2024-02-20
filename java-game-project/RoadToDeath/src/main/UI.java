package main;

import objects.OBJ_Heart;
import objects.OBJ_Key;
import objects.SuperObjects;

import javax.imageio.ImageIO;
import java.awt.*;
import java.awt.image.BufferedImage;
import java.io.IOException;
import java.text.DecimalFormat;

public class UI {

    GamePanel gp;
    Graphics2D g2;
    Font arial_40, arial_40B;
    BufferedImage keyImage;
    public boolean messageOn = false;
    public String message = "";
    int messageCounter = 0;
    public boolean gameFinished = false;
    public String currentDialogue = "";
    BufferedImage heart_full,heart_half,heart_zero;
    BufferedImage PlayerImg;
    public int commandNum = 0;
    public int titleScreenState = 0; // 0 for first screen 1 for 2nd screen


    double playTime;
    DecimalFormat dFormat = new DecimalFormat("#0.00");

    public UI(GamePanel gp){
        this.gp = gp;
        arial_40 = new Font("Fixedsys normal", Font.PLAIN, 40);
        arial_40B = new Font("Fixedsys normal", Font.BOLD, 40);
        SuperObjects heart = new OBJ_Heart(gp);
        heart_full = heart.fullHeart;
        heart_half = heart.halfHeart;
        heart_zero = heart.zeroHeart;
        try {
            getImg();
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }

    public void showMessage(String text){
        message = text;
        messageOn = true;
    }

    public void draw(Graphics2D g2){
        this.g2 = g2;

        g2.setFont(arial_40);
        g2.setColor(Color.white);

        if (gp.gameState == gp.titleState){
            drawTitleScreen();
        }

        if(gp.gameState == gp.playState){
            drawPlayerLife();

        }
        if(gp.gameState == gp.pauseState){
            drawPauseScreen();
        }
    }

    private void drawPlayerLife() {

        int x = gp.tileSize/2;
        int y = gp.tileSize/2;
        int i=0;

        //MAX LIFE
        while(i < gp.player.maxLife/2){
            g2.drawImage(heart_zero,x,y,null);
            i++;
            x+= gp.tileSize;
        }
        //RESET VALUES
        x = gp.tileSize/2;
        y = gp.tileSize/2;
        i=0;
        //PLAYER LIFE
        while(i<gp.player.life){
            g2.drawImage(heart_half,x,y,null);
            i++;
            if(i<gp.player.life){
                g2.drawImage(heart_full,x,y,null);
            }
            i++;
            x+=gp.tileSize;
        }
    }

    private void drawDialogueScreen() {
        //WINDOW
        int x = gp.tileSize * 2;
        int y = gp.tileSize / 2;
        int width = gp.screenWidth - (gp.tileSize*4);
        int height = gp.tileSize*4;
        drawSubWindow(x,y,width,height);

        g2.setFont(g2.getFont().deriveFont(Font.PLAIN,32F));
        x += gp.tileSize;
        y += gp.tileSize;

        for(String line : currentDialogue.split("\n")){
            g2.drawString(currentDialogue,x,y);
            y+=40;
        }


    }
    public void drawSubWindow(int x, int y, int width, int height){
        Color b = new Color(0,0,0,210);
        Color w = new Color(255,255,255);
        g2.setColor(b);
        g2.fillRoundRect(x,y,width,height,35,35);
        g2.setStroke(new BasicStroke(5));
        g2.setColor(w);
        g2.drawRoundRect(x+5,y+5,width-10,height-10,25,25);

    }
    public void getImg() throws IOException {
        PlayerImg = ImageIO.read(getClass().getClassLoader().getResourceAsStream("champion/idledown1.png"));
    }

    public void drawTitleScreen(){
        if(titleScreenState == 0){
            //title name
            g2.setFont(g2.getFont().deriveFont(Font.BOLD,96));
            String text = "Vamonos";
            int x = getXforCenteredText(text);
            int y = gp.tileSize*3;

            g2.setColor(Color.gray);
            g2.drawString(text, x+3, y+3);

            g2.setColor(Color.white);
            g2.drawString(text, x, y);

            //character image
            x = gp.screenWidth/2 - (gp.tileSize*2)/2;
            y += gp.tileSize;
            g2.drawImage(PlayerImg, x, y, gp.tileSize*2, gp.tileSize*2, null);

            //MENU
            g2.setFont(g2.getFont().deriveFont(Font.BOLD,48F));
            text = "NEW GAME";
            x = getXforCenteredText(text);
            y += gp.tileSize*4;
            g2.drawString(text, x, y);
            if (commandNum == 0) {
                g2.drawString(">", x-gp.tileSize, y);
            }

            g2.setFont(g2.getFont().deriveFont(Font.BOLD,48F));
            text = "LOAD GAME";
            x = getXforCenteredText(text);
            y += gp.tileSize;
            g2.drawString(text, x, y);
            if (commandNum == 1) {
                g2.drawString(">", x-gp.tileSize, y);
            }

            g2.setFont(g2.getFont().deriveFont(Font.BOLD,48F));
            text = "QUIT";
            x = getXforCenteredText(text);
            y += gp.tileSize;
            g2.drawString(text, x, y);
            if (commandNum == 2) {
                g2.drawString(">", x-gp.tileSize, y);
            }
        }
        else if (titleScreenState == 1){

            g2.setColor(Color.white);
            g2.setFont(g2.getFont().deriveFont(42F));

            String text = "Choisis ta classe";
            int x = getXforCenteredText(text);
            int y = gp.tileSize*3;
            g2.drawString(text, x, y);

            text = "Guerrier";
            x = getXforCenteredText(text);
            y += gp.tileSize;
            g2.drawString(text, x, y);
            if(commandNum == 0){
                g2.drawString(">", x- gp.tileSize, y);
            }

            text = "Archer";
            x = getXforCenteredText(text);
            y += gp.tileSize;
            g2.drawString(text, x, y);
            if(commandNum == 1){
                g2.drawString(">", x- gp.tileSize, y);
            }

            text = "Mage";
            x = getXforCenteredText(text);
            y += gp.tileSize;
            g2.drawString(text, x, y);
            if(commandNum == 2){
                g2.drawString(">", x- gp.tileSize, y);
            }

            text = "Back";
            x = getXforCenteredText(text);
            y += gp.tileSize*2;
            g2.drawString(text, x, y);
            if(commandNum == 3){
                g2.drawString(">", x- gp.tileSize, y);
            }
        }


    }
    public void drawPauseScreen(){

        String text = "PAUSED";
        int x = getXforCenteredText(text);
        int y = gp.screenHeight/2;

        g2.drawString(text,x,y);
    }
    public int getXforCenteredText(String text){
        int length = (int)g2.getFontMetrics().getStringBounds(text,g2).getWidth();
        int x = gp.screenWidth/2 - length/2;
        return x;
    }
}




