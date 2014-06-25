//
//  UISwitchGroup.m
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-12-3.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UISwitchGroup.h"

@implementation UISwitchGroup

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self)
    {
        // Initialization code
    }
    return self;
}

-(void) setDelegate:(id<UISwitchGroupDelegate>) delegate
{
    self.myDelegate = delegate;
}

- (void) didCreateViewComplete
{
    [super didCreateViewComplete];
    int i = 0;
    for (KidUISwitch *item in self.itemList)
    {
        [item setTag:i];
        [item setCallBack:self];
        i++;
    }
}

//- (void) didSwitchClicked:(UISwitch *)sender
- (void) didKidUISwitchValeuChange:(KidUISwitch *)sender isSWitch:(BOOL)switchValue
{
    if(self.myDelegate)
    {
        [self.myDelegate didGroupSwitchChanged:sender];
    }
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
