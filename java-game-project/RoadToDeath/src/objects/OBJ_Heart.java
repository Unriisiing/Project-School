package objects;

import main.GamePanel;

public class OBJ_Heart extends SuperObjects {

    GamePanel gp;

    public OBJ_Heart(GamePanel gp) {
        this.gp = gp;
        name = "Heart";
        collision = true;

        // Use the setupSpriteSheetFrames method to set up sprite sheet frames
        setupSpriteSheetFrames("objects/life.png", 1, 5, gp.tileSize,0.7);

        // Assuming spriteSheetFrames[0] contains the full heart frame
        fullHeart = spriteSheetFrames[0][0];

        // Assuming spriteSheetFrames[0] contains the half heart frame
        halfHeart = spriteSheetFrames[0][2];

        // Assuming spriteSheetFrames[0] contains the zero heart frame
        zeroHeart = spriteSheetFrames[0][4];
    }
}