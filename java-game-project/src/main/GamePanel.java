package main;

import entity.Entity;
import entity.Player;
import objects.OBJ_Key;
import objects.SuperObjects;
import tile.TileManager;

import javax.swing.*;
import java.awt.*;

public class GamePanel extends JPanel implements Runnable{

    //------------- SCREEN SETTINGS -----------------
    final int originalTileSize = 16; // 16x16 tile
    // Scale of the tile
    final int scale = 4;
    //Size of the game;
    public final int tileSize = originalTileSize * scale; // 48x48 tile
    public final int maxScreenCol = 16;
    public final int maxScreenRow = 12;
    //Size of the game screen
    public final int screenWidth = tileSize * maxScreenCol; // 768 pixels
    public final int screenHeight = tileSize * maxScreenRow; // 576 pixels
    //WORLD MAP SETTINGS
    public final int maxWorldCol = 50;
    public final int maxWorldRow = 50;
    //FPS
    int FPS = 60;
    //System
    TileManager tileM = new TileManager(this);
    public KeyHandler keyH = new KeyHandler(this);
    Sound music = new Sound();
    Sound se = new Sound();
    //Collision
    public CollisionChecker cChecker = new CollisionChecker(this);
    //Asset
    public AssetSetter aSetter = new AssetSetter(this);
    //UI
    public UI ui = new UI(this);
    //GameLoop
    Thread gameThread;
    //Entities And Objects
    public Player player = new Player(this,keyH);
    //We prepare 10 slots for objects
    public SuperObjects obj[] = new SuperObjects[10];
    //Entities
    public Entity npc[] = new Entity[10];
    //GameState
    public int gameState;
    public final int playState = 1;
    public final int pauseState = 2;
    public final int dialogueState = 3;
    //Event
    public EventHandler eHandler = new EventHandler(this);


    public GamePanel(){
        //Set the size with the screenWidth and the screenHeight
        this.setPreferredSize(new Dimension(screenWidth,screenHeight));
        //Set the background color to black
        this.setBackground(Color.black);
        //The drawing will be set in a buffer
        this.setDoubleBuffered(true);
        //Recognize the key
        this.addKeyListener(keyH);
        //Focus to receive a key
        this.setFocusable(true);

    }

    public void setupGame(){

        aSetter.setObject();
        aSetter.setNPC();
        playMusic(0);
        stopMusic();
        gameState = playState;




    }
    public void startGameThread(){

        gameThread = new Thread(this);
        gameThread.start();

    }

    @Override
    public void run() {

        //We draw the screen every 0.016 seconds
        double drawInterval = 1000000000/FPS;

        double delta = 0;
        long lastTime = System.nanoTime();
        long currentTime;
        long timer = 0;
        int drawCount =0;

        //Game Loop (core)

        //As long as the thread is not null the game will run
        while(gameThread != null){

        currentTime = System.nanoTime();

        delta += (currentTime - lastTime) / drawInterval;
        timer += (currentTime - lastTime);
        lastTime = currentTime;

        if(delta >=1){

            //UPDATE : update information
            update();
            //DRAW : drawn information
            repaint();

            delta-- ;
            drawCount++;

        }
            if(timer >= 1000000000){
                System.out.println("FPS: " + drawCount);
                drawCount = 0;
                timer = 0;
            }
        }

    }
    public void update(){
        if(gameState == playState){
            player.update();
            for(int i = 0 ; i < npc.length; i++){
                if(npc[i] != null){
                    npc[i].update();
                }
            }
        }
        if(gameState == pauseState){

        }

    }
    //built it method in java
    public void paintComponent(Graphics g){

        //super means the parent of this class , this parent class JPanel
        super.paintComponent(g);

        //Graphics2D help with the control of geometry and it similar to Graphics
        Graphics2D g2 = (Graphics2D)g;
        //Draw the tile
        tileM.draw(g2);
        //Draw the objects;
        for(int i = 0; i< obj.length;i++){
            if(obj[i] != null) {
                obj[i].draw(g2,this);
            }
        }
        //Draw the NPC
        for(int i = 0; i< npc.length;i++){
            if(npc[i] != null){
                npc[i].draw(g2);
            }
        }
        //Draw the player
        player.draw(g2);
        //Draw the UI
        ui.draw(g2);
        //Dispose of this graphics context and release any resources, saves memory
        g2.dispose();

    }
    public void playMusic(int i){

        music.setFile(i);
        music.play();
        music.loop();

    }
    public void stopMusic(){
        music.stop();
    }

    public void playSE(int i){
        se.setFile(i);
        se.play();
    }
}
