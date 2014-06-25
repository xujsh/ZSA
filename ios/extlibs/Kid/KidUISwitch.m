//
//  KidUISwitch.m
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-18.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "KidUISwitch.h"

@implementation KidUISwitch
@synthesize btn, isYES, offLabel, onLabel, myDelegate;

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self)
    {
        // Initialization code
    }
    return self;
}

-(id)initwithSliderBtnFile:(NSString *) sliderBtnFile bgImgFile:(NSString *) bgImgFile defaultSelect:(BOOL) defaultType
{
    return [self initwithSliderBtnFile:sliderBtnFile bgImgFile:bgImgFile onString:@"On" offString:@"Off" defaultSelect:defaultType];
}

-(id)initwithSliderBtnFile:(NSString *) sliderBtnFile bgImgFile:(NSString *) bgImgFile onString:(NSString *)onStr offString:(NSString *) offStr defaultSelect:(BOOL) defaultType
{
    self = [super init];
    if(self)
    {
        float thisW = 0;
        float thisH = 0;
        //CCMenuItemImage *bg = [CCMenuItemImage itemWithNormalImage:bgImgFile selectedImage:bgImgFile target:self selector:@selector(didBGClick:)];
        UIImageView *tmpBlackBG = [[UIImageView alloc] initWithImage:[UIImage imageNamed:bgImgFile]];
        tmpBlackBG.userInteractionEnabled = YES;
        UITapGestureRecognizer *singleTap = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(didBGClick:)];
        [tmpBlackBG addGestureRecognizer:singleTap];
        bgWidth = tmpBlackBG.frame.size.width;
        bgHeigth = tmpBlackBG.frame.size.height;
        [self addSubview:tmpBlackBG];
        //self.blackBG = tmpBlackBG;
        //[tmpBlackBG release];
        /*
        CCMenuItemImage *tmpBtn = [CCMenuItemImage itemWithNormalImage:sliderBtnFile selectedImage:sliderBtnFile target:self selector:@selector(didBGClick:)];
        tmpBtn.position = ccp(-15, 0);
        self.btn = tmpBtn;
        */
        UIImage *btnUIImage = [UIImage imageNamed:sliderBtnFile];
        UIButton *tmpBtn = [UIButton buttonWithType:UIButtonTypeCustom];
        [tmpBtn setBackgroundImage:btnUIImage forState:UIControlStateNormal];
        [tmpBtn setFrame:CGRectMake(0, 0, btnUIImage.size.width, btnUIImage.size.height)];
        [tmpBtn addTarget:self action:@selector(didBGClick:) forControlEvents:UIControlEventTouchUpInside];
        btnWidth = tmpBtn.frame.size.width;
        btnHeight = tmpBtn.frame.size.height;
        [self addSubview:tmpBtn];
        self.btn = tmpBtn;
        
        thisW = tmpBlackBG.frame.size.width + tmpBtn.frame.size.width;
        thisH = tmpBtn.frame.size.height;
        
        [tmpBtn release];
        /*
        CCMenu *menu = [CCMenu menuWithItems:bg, tmpBtn, nil];
        menu.position = ccp(0, 0);
        [self addChild:menu];
        */
        /*CCLabelTTF *tmpOnLabel = [CCLabelTTF labelWithString:onStr fontName:@"Helvetica" fontSize:20];
        tmpOnLabel.position = ccp(60, 0);
        [self addChild:tmpOnLabel];
        self.onLabel = tmpOnLabel;
        [tmpOnLabel release];
        */
        int labelWidth = 50;
        int labelHeigth = 20;
        int labelY =(bgHeigth - labelHeigth ) / 2;
        
        UILabel *tmpOnLabel = [[UILabel alloc] initWithFrame:CGRectMake(bgWidth + 20, labelY, labelWidth, labelHeigth)];
        [tmpOnLabel setText:onStr];
        tmpOnLabel.textColor = [UIColor whiteColor];
        tmpOnLabel.font = [UIFont boldSystemFontOfSize:16];
        tmpOnLabel.textAlignment = UITextAlignmentLeft;
        [self addSubview:tmpOnLabel];
        self.onLabel = tmpOnLabel;
        [tmpOnLabel release];
        
        UILabel *tmpOffLabel = [[UILabel alloc] initWithFrame:CGRectMake(labelWidth * -1 - 20, labelY, labelWidth, labelHeigth)];
        [tmpOffLabel setText:offStr];
        tmpOffLabel.textColor = [UIColor whiteColor];
        tmpOffLabel.font = [UIFont boldSystemFontOfSize:14];
        tmpOffLabel.textAlignment = UITextAlignmentRight;
        [self addSubview:tmpOffLabel];
        self.offLabel = tmpOffLabel;
        [tmpOffLabel release];
        
        //NSLog(@"isYES1 %d", defaultType);
        self.isYES = !defaultType;
        //NSLog(@"isYES2 %d", self.isYES);
        [self changeSwitch];
        NSLog(@"thisw: %f, thish: %f", thisW, thisH);
        [self setFrame:CGRectMake(self.frame.origin.x, self.frame.origin.y, thisW, thisH)];
    }
    return self;
}

- (void) didBGClick :(id) sender
{
    [self changeSwitch];
    if(self.myDelegate)
    {
        //[self.myDelegate didCCSwitchValeuChange:self isSWitch:self.isYES];
        [self.myDelegate didKidUISwitchValeuChange:self isSWitch:self.isYES];
    }
    NSLog(@"isYES %d", self.isYES);
}

- (void) setCallBack:(id<KidUISwitchDelegate>)callBack
{
    self.myDelegate = callBack;
}

- (void) changeSwitch
{
    int btnNoX = -15;
    int btnYesX = bgWidth - btnWidth + 15;
    int btnY =( bgHeigth - btnHeight ) / 2;
    if (self.isYES)
    {
        //self.btn.position = ccp(-15, 0);
        //self.onLabel.color = ccc3(184, 147, 147);
        //self.offLabel.color = ccc3(230, 230, 230);
        [self.btn setFrame:CGRectMake(btnNoX, btnY, self.btn.frame.size.width, self.btn.frame.size.height)];
        [self.onLabel setTextColor:[UIColor colorWithRed:184/255.0 green:147/255.0 blue:147/255.0 alpha:1]];
        [self.offLabel setTextColor:[UIColor colorWithRed:230/255.0 green:230/255.0 blue:230/255.0 alpha:1]];
        
    }
    else
    {
        //self.btn.position = ccp(15, 0);
        //self.offLabel.color = ccc3(184, 147, 147);
        //self.onLabel.color = ccc3(230, 230, 230);
        [self.btn setFrame:CGRectMake(btnYesX, btnY, self.btn.frame.size.width, self.btn.frame.size.height)];
        [self.offLabel setTextColor:[UIColor colorWithRed:184/255.0 green:147/255.0 blue:147/255.0 alpha:1]];
        [self.onLabel setTextColor:[UIColor colorWithRed:230/255.0 green:230/255.0 blue:230/255.0 alpha:1]];
    }
    self.isYES = !self.isYES;
}

/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
