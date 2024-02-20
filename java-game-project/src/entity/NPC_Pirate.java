package entity;

import main.GamePanel;

import java.util.Random;

public class NPC_Pirate extends Entity{

    public NPC_Pirate(GamePanel gp){
        super(gp);
        setDefaultValues();

        setupSpriteSheetFrames("NPC_Pirate_walk","npc/", 4, 8, gp.tileSize);
        setDialogues();
    }

    public void setDefaultValues() {
        worldX = gp.tileSize * 30;
        worldY = gp.tileSize * 30;
        speed = 1;
        direction = "down";
    }
    public void setDialogues(){
        dialogues[0] = "Hello, Sailor !";
        dialogues[1] = "What are you looking for ?";
        dialogues[2] = "Where is my rum !";
        dialogues[3] = "You will remember me as the best PIRATE !";
    }
    @Override
    public void setAction(){

        actionLockCounter++;


        if(actionLockCounter == 120){


        Random random = new Random();
        int i = random.nextInt(100)+1;

        if(i<=25){
            direction = DIRECTION_UP;
        }
        if(i>25 && i<=50){
            direction = DIRECTION_DOWN;
        }
        if(i > 50 && i <=75){
            direction = DIRECTION_LEFT;
        }
        if(i > 75 && i <= 100){
            direction = DIRECTION_RIGHT;
        }
        actionLockCounter = 0;
        }
    }
    public void speak(){

        //Do this character specific stuff !
        super.speak();

    }
}
